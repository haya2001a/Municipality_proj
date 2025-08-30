<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPermissions = [
            'manage system',       // إدارة النظام
            'manage users',        // إدارة المستخدمين
            'manage roles',        // إدارة الأدوار
            'manage services',     // إدارة الخدمات
            'review requests',     // مراجعة الطلبات
            'view reports',        // عرض التقارير
            'manage complaints',   // إدارة الشكاوى
        ];

        // صلاحيات الموظف
        $employeePermissions = [
            'view requests',       // عرض الطلبات
            'manage complaints',   // معالجة الشكاوى
            'manage payments',     // إدارة المدفوعات
            'citizen communication'// التواصل مع المواطنين
        ];

        // صلاحيات المواطن
        $citizenPermissions = [
            'make request',        // تقديم طلب
            'track request',       // متابعة الطلب
            'make complaint',      // تقديم شكوى
            'view account',        // عرض الحساب المالي
            'citizen support'      // التواصل مع الدعم
        ];

        // Merge all permissions
        $allPermissions = array_merge(
            $adminPermissions,
            $employeePermissions,
            $citizenPermissions
        );

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions

        // مشرف عام
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo($adminPermissions);

        // موظف
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $employeeRole->givePermissionTo($employeePermissions);

        // مواطن
        $citizenRole = Role::firstOrCreate(['name' => 'citizen']);
        $citizenRole->givePermissionTo($citizenPermissions);

        // Create admin user and assign role
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'مؤيد رواشدة',
                'password' => Hash::make('123'),
                'national_id' => '123',
                'phone' => '0591234567',
                'gender' => 'ذكر',
                'notes' => 'System administrator'
            ]
        );
        $adminRole = Role::where('name', 'admin')->first();
        $adminUser->assignRole($adminRole);
    }
}
