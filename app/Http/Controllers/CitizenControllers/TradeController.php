<?php

namespace App\Http\Controllers\CitizenControllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TradeController extends Controller
{
    public function show(string $id)
    {
        $trade = Trade::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('citizen.trades', compact('trade'));
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
}
