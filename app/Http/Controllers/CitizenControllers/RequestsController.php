<?php

namespace App\Http\Controllers\CitizenControllers;

use App\Http\Controllers\Controller;
use App\Models\RequestAttachment;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $serviceFilter = $request->input('service');
        $statusFilter = $request->input('status');
        $priorityFilter = $request->input('priority');

        $requests = ServiceRequest::with(['user', 'service'])->where('user_id', auth()->id());
        ;

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

        return view('citizen.requests', compact('requests', 'services'));
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

        $validator = Validator::make($request->all(), ServiceRequest::rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $service = Service::findOrFail($request->service_id);

        $requestModel = new ServiceRequest();
        $requestModel->user_id = auth()->id();
        $requestModel->service_id = $service->id;
        $requestModel->department_id = $service->department_id;
        $requestModel->priority = $service->priority ?? 'غير عاجل';
        $requestModel->price = $service->price ?? null;
        $requestModel->status = 'بانتظار الموافقة';
        $requestModel->save();


        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('service_requests/' . $requestModel->id, 'public');

                RequestAttachment::create([
                    'request_id' => $requestModel->id,
                    'file_name' => basename($path),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('citizen.requests.index')->with('success', "تم إضافة طلب الخدمة بنجاح");
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
