<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Mail\NewUserCreatedMail;
use App\Models\User;
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

    /**
     * Store a newly created resource in storage.
     */
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
        // Mail::to($user->email)->send(new NewUserCreatedMail($user));

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
                ->with('form', 'edit')       // <-- نحدد أن الفورم تعديل
                ->with('editing_user_id', $id); // <-- حفظ الـ id للمودال
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
