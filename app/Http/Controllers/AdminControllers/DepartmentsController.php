<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function getDepartments()
    {
        $departments = Department::all();

        return response()->json($departments);
    }
}
