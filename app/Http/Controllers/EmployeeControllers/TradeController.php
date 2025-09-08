<?php

namespace App\Http\Controllers\EmployeeControllers;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Notifications\TradeStatusChanged;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Trade::where('status', 'سارية')
        ->where('expiry_date', '<', now())
        ->update([
            'status' => 'منتهية',
            'fees' => \DB::raw('fees + 25')
        ]);

        $trades = Trade::with('user');

        if ($request->status) {
            $trades->where('status', $request->status);
        }

        if ($request->user_name) {
            $trades->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        $trades = $trades->orderBy('created_at', 'desc')->paginate(10);

        return view('employee.trades', compact('trades'));
    }


    public function show(string $id)
    {
        $trade = Trade::with('user')->findOrFail($id);
        return view('trades.show', compact('trade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:سارية,منتهية',
            'paid_fees' => 'required|numeric|min:0',
        ]);

        $trade = Trade::findOrFail($id);

        $oldStatus = $trade->status;

        $trade->status = $validated['status'];
        $trade->paid_fees += $validated['paid_fees'];
        $trade->fees -= $validated['paid_fees'];

        if ($validated['paid_fees'] > 0) {
            $trade->last_payment = now();
        }

        if($oldStatus == 'منتهية' && $validated['status'] == 'سارية'){
            $trade->issue_date = now();
            $trade->expiry_date = now()->addYear();
        }

        $trade->save();

        $user = $trade->user;
        $user->notify(new TradeStatusChanged($trade, $validated['paid_fees']));

        return redirect()->route('employee.trades.index')->with('success', 'تم تعديل الرخصة بنجاح');
    }
}
