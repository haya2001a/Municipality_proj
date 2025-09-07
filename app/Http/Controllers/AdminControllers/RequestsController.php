<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
       public function index(Request $request)
    {
        $userFilter = $request->input('user');
    $serviceFilter = $request->input('service');
    $statusFilter = $request->input('status');
    $priorityFilter = $request->input('priority');

    $requests = ServiceRequest::with(['user', 'service'])
        ->whereNull('assigned_to')
        ->where('status', 'بانتظار الموافقة'); 

    if ($userFilter) {
        $requests->whereHas('user', function ($query) use ($userFilter) {
            $query->where('name', 'like', "%{$userFilter}%");
        });
    }

    if ($serviceFilter) {
        $requests->where('service_id', $serviceFilter);
    }

    if ($priorityFilter) {
        $requests->where('priority', $priorityFilter);
    }

    $requests = $requests->latest()->paginate(10);

    $services = Service::all();

    return view('admin.requests', compact('requests', 'services'));
    }

   
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        
    }

   
    public function show(string $id)
    {
       
    }

    public function edit(string $id)
    {
       
    }

   
    public function update(Request $request, string $id)
    {
       
    }

    public function destroy(string $id)
    {
       
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
