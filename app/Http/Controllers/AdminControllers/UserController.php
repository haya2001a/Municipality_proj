<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Mail\NewUserCreatedMail;
use App\Models\Trade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roleFilter = $request->input('role');
        $nameFilter = $request->input('name');

        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        });


        if ($roleFilter) {
            $users->whereHas('roles', function ($query) use ($roleFilter) {
                $query->where('name', $roleFilter);
            });
        }

        if ($nameFilter) {
            $users->where('name', 'like', "%{$nameFilter}%");
        }

        $users = $users->latest()->paginate(10);

        $roles = Role::where('name', '!=', 'admin')->get();

        return view('admin.users', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users');

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), User::rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'add');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->national_id),
            'national_id' => $request->national_id,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'department_id' => $request->department_id,
            'notes' => $request->notes,
        ]);


        $user->roles()->attach($request->role_id);

        if ($request->has('has_license') && $request->has_license == '1') {
            Trade::create([
                'user_id' => $user->id,
                'trade_name' => $request->trade_name,
                'opened_since' => $request->opened_since,
                'issue_date' => $request->issue_date,
                'expiry_date' => Carbon::parse($request->issue_date)->addYear()->format('Y-m-d'),
                'last_payment' => $request->last_payment,
                'status' => $request->license_status,
                'fees' => Trade::calculateFees($request->last_payment),
            ]);
        }
        Mail::to($user->email)->send(new NewUserCreatedMail($user));

        return redirect()->route('admin.users.index')->with('success', 'تمت إضافة المستخدم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), User::rules($id));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'edit')
                ->with('editing_user_id', $id);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->national_id = $request->national_id;


        $user->save();

        return redirect()->route('admin.users.index')->with('success', "تم تعديل بيانات المستخدم بنجاح");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
