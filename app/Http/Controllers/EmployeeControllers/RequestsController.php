<?php

namespace App\Http\Controllers\EmployeeControllers;

use App\Http\Controllers\Controller;
use App\Models\RequestAttachment;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\UserAccount;
use App\Notifications\RequestStatusChanged;
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

        $requests = ServiceRequest::with(['user', 'service', 'attachments'])
            ->whereHas('service.department', function ($q) {
                $q->where('id', auth()->user()->department_id);
            });

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


        $services = Service::where('department_id', auth()->user()->department_id)->get();

        return view('employee.requests', compact('requests', 'services'));
    }

    public function updateStatus(Request $request, $id)
    {
        $requestModel = ServiceRequest::findOrFail($id);

        $oldStatus = $requestModel->status;
        $newStatus = $request->status;

        $requestModel->status = $request->status;
        $requestModel->save();

        $this->updateUserAccount($requestModel, $oldStatus, $newStatus);

        $user = $requestModel->user;
        $service = $requestModel->service;

        $user->notify(new RequestStatusChanged($service, $oldStatus, $newStatus));

        return back()->with('success', 'تم تحديث الحالة بنجاح');
    }

    protected function updateUserAccount($requestModel, $oldStatus, $newStatus)
    {
        $price = $requestModel->price ?? 0;
        $userId = $requestModel->user_id;

        if ($price <= 0) {
            return;
        }

        $account = UserAccount::firstOrCreate(
            ['user_id' => $userId],
            ['total_charged' => 0, 'total_paid' => 0]
        );


        if ($newStatus === 'مكتمل' && $oldStatus !== 'مكتمل') {
            $account->increment('total_charged', $price);
        }


        if ($newStatus === 'مدفوع' && $oldStatus !== 'مدفوع') {
            $account->increment('total_paid', $price);
        }
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
