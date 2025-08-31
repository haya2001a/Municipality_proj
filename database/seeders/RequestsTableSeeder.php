<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $services = Service::all();
        $departments = Department::all();

        if ($users->isEmpty() || $services->isEmpty() || $departments->isEmpty()) {
            $this->command->info('يجب أن تحتوي الجداول على بيانات: users, services, departments');
            return;
        }

        $sampleData = [
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'status' => 'بانتظار الموافقة',
                'priority' => 1,
                'price' => 150.00,
                'department_id' => $departments->random()->id,
            ],
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'status' => 'بانتظار الموافقة',
                'priority' => 2,
                'price' => 250.50,
                'department_id' => $departments->random()->id,
            ],
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'status' => 'مرفوض',
                'priority' => 3,
                'price' => 75.25,
                'department_id' => $departments->random()->id,
            ],
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'status' => 'مدفوع',
                'priority' => 1,
                'price' => 120.00,
                'department_id' => $departments->random()->id,
            ],
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'status' => 'مكتمل',
                'priority' => 2,
                'price' => 300.00,
                'department_id' => $departments->random()->id,
            ],
        ];

        foreach ($sampleData as $data) {
            ServiceRequest::create($data);
        }

    }
}
