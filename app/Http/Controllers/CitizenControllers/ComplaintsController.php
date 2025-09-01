<?php

namespace App\Http\Controllers\CitizenControllers;

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

        $complaints = Complaint::where('user_id', auth()->id());

        if ($statusFilter) {
            $complaints->where('status', $statusFilter);
        }

        $complaints = $complaints->latest()->paginate(10);

        return view('citizen.complaints', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('citizen.complaints');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Complaint::rules());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Complaint::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'قيد الانتظار', // default
            'closed_at'   => null,
        ]);
        return redirect()->route('citizen.complaints.index')->with('success', 'تم إرسال الشكوى بنجاح');
    }

    public function show(string $id)
    {
        $complaint = Complaint::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($complaint);
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

        $complaint->title       = $request->title;
        $complaint->description = $request->description;
        $complaint->status      = $request->status;
        $complaint->closed_at   = $request->status === 'مكتمل' ? now() : null;

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
