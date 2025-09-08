<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function getRoles()
    {
        $roles = Role::whereIn('name', ['employee', 'citizen'])->get();

        return response()->json($roles);
    }
}
