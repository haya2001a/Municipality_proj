<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee = User::create([
            'name' => 'أحمد الموظف',
            'email' => 'employee@example.com',
            'national_id' => '123456777',
            'password' => Hash::make('12345678'),
        ]);
        $employee->assignRole('employee');

        // إضافة مستخدم مواطن
        $citizen = User::create([
            'name' => 'سارة المواطن',
            'email' => 'citizen@example.com',
            'national_id' => '123456788',
            'password' => Hash::make('12345678'),
        ]);
        $citizen->assignRole('citizen');
    }
}
