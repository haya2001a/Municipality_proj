<?php

namespace App\Http\Controllers\EmployeeControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employee.dashboard');
    }
}
