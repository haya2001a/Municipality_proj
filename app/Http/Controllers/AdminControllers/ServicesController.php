<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $departmentFilter = $request->input('department');
        $nameFilter = $request->input('name');
        $statusFilter = $request->input('status');
        $priorityFilter = $request->input('priority');

        $services = Service::query();

        if ($departmentFilter) {
            $services->where('department_id', $departmentFilter);
        }

        if ($nameFilter) {
            $services->where('name', 'like', "%{$nameFilter}%");
        }
        if ($statusFilter) { 
            $services->where('status', $statusFilter);
        }

        if ($priorityFilter) {
            $services->where('priority', $priorityFilter);
        }

        $services = $services->latest()->paginate(10);

        $departments = Department::all();

        return view('admin.services', compact('services', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.services', compact('departments'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Service::rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'add');
        }

        $data = $request->all();

        if (!empty($data['required_documents'])) {
            $docsArray = preg_split("/\r\n|\n|\r|,/", $data['required_documents']);
            $data['required_documents'] = json_encode(array_map('trim', $docsArray));
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'تمت إضافة الخدمة بنجاح');
    }

    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        $validator = Validator::make($request->all(), Service::rules());


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'edit')
                ->with('editing_service_id', $id);
        }

        $service->update($request->all());

        return redirect()->route('admin.services.index')->with('success', 'تم تعديل الخدمة بنجاح');
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة بنجاح');
    }
}
