<?php

namespace App\Http\Controllers\CitizenControllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::select('id', 'name', 'description')->orderBy('name')->get();

        return view('citizen.dashboard', compact('departments'));
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
