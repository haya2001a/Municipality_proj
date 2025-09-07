<?php

namespace App\Http\Controllers\EmployeeControllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        return redirect()->route('employee.complaints.index')->with('success', 'تم تعديل الشكوى بنجاح');
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
