<?php

namespace App\Http\Controllers\EmployeeControllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Notifications\ComplaintStatusChanged;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusFilter = $request->input('status');

        $complaints = Complaint::where('department_id', auth()->user()->department_id);


        if ($statusFilter) {
            $complaints->where('status', $statusFilter);
        }

        $complaints = $complaints->latest()->paginate(10);

        return view('employee.complaints', compact('complaints'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'response' => 'nullable|string',
            'status' => 'required|in:قيد الانتظار,مرفوض,مكتمل',
        ]);


        $complaint->response = $request->response;
        $complaint->status = $request->status;

    
        if ($request->status != 'قيد الانتظار') {
            $complaint->closed_at = now();
        } else {
            $complaint->closed_at = null; 
        }

        $complaint->save();

        $user = $complaint->user;
        $user->notify(new ComplaintStatusChanged($request->response, $request->status, $complaint->title));

        return redirect()->route('employee.complaints.index')->with('success', 'تم تعديل الشكوى بنجاح');
    }
}
