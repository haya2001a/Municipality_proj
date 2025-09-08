<?php

namespace App\Http\Controllers\CitizenControllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index()
    {
        $departments = Department::select('id', 'name', 'description')->orderBy('name')->get();

        return view('citizen.dashboard', compact('departments'));
    }

    public function getDepartmentsList()
    {
        $departments = Department::all();
        return view('citizen.dashboard', compact('departments'));
    }

    public function getDepartmentServices($id)
    {
        $department = Department::with('services')->findOrFail($id);

        return view('citizen.services', compact('department'));
    }
}
