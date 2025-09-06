<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // عدد الطلبات لكل شهر
    $monthlyRequests = ServiceRequest::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->pluck('count', 'month')
        ->toArray();

    // أكثر الخدمات طلباً
    $serviceDistribution = ServiceRequest::select('service_id', DB::raw('COUNT(*) as count'))
        ->groupBy('service_id')
        ->with('service')
        ->get()
        ->map(function ($item) {
            return [
                'name' => $item->service ? $item->service->name : 'غير محدد',
                'count' => $item->count
            ];
        });

    return view('admin.dashboard', compact('monthlyRequests', 'serviceDistribution'));
      
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
}
