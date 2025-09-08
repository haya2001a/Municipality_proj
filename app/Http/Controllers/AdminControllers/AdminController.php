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
        $monthlyRequests = ServiceRequest::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

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
}
