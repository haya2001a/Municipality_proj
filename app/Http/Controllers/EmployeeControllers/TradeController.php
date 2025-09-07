<?php

namespace App\Http\Controllers\EmployeeControllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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


    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
        $trade = Trade::with('user')->findOrFail($id);
        return view('trades.show', compact('trade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        $this->authorize('update', $complaint);
        return response()->json($complaint);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $complaint = Complaint::where('user_id', auth()->id())->findOrFail($id);

        $validator = Validator::make($request->all(), Complaint::rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'edit')
                ->with('editing_complaint_id', $id);
        }

        $complaint->title = $request->title;
        $complaint->description = $request->description;
        $complaint->status = $request->status;
        $complaint->closed_at = $request->status === 'مكتمل' ? now() : null;

        $complaint->save();

        return redirect()->route('citizen.complaints.index')->with('success', 'تم تعديل الشكوى بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $complaint = Complaint::where('user_id', auth()->id())->findOrFail($id);
        $complaint->delete();

        return redirect()->route('citizen.complaints.index')->with('success', 'تم حذف الشكوى بنجاح');
    }
}
