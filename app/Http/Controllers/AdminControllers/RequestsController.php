<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userFilter = $request->input('user');
        $serviceFilter = $request->input('service');
        $statusFilter = $request->input('status');
        $priorityFilter = $request->input('priority');

        $requests = ServiceRequest::with(['user', 'service'])->whereNull('assigned_to');;


        if ($userFilter) {
            $requests->whereHas('user', function ($query) use ($userFilter) {
                $query->where('name', 'like', "%{$userFilter}%");
            });
        }

        if ($serviceFilter) {
            $requests->where('service_id', $serviceFilter);
        }

        if ($statusFilter) {
            $requests->where('status', $statusFilter);
        }

        if ($priorityFilter) {
            $requests->where('priority', $priorityFilter);
        }

        $requests = $requests->latest()->paginate(10);

        $services = Service::all();

        return view('admin.requests', compact('requests', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getEmployees($id)
    {
        $request = ServiceRequest::findOrFail($id);

        $employees = User::where('department_id', $request->department_id)->get(['id', 'name']);

        return response()->json($employees);
    }


    public function assign(Request $req, $id)
    {
        $req->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $request = ServiceRequest::findOrFail($id);
        $request->update([
            'assigned_to' => $req->assigned_to,
        ]);

        return redirect()->route('admin.requests.index')->with('success', 'تم إسناد الطلب بنجاح');
    }
}
