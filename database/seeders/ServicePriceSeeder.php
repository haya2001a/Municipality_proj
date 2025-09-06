<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();

        foreach ($services as $service) {
            // توليد سعر عشوائي من 20 إلى 300، ينتهي بالـ 0 أو 5
            $price = rand(4, 60) * 5; // 4*5=20, 60*5=300
            $service->price = $price;
            $service->save();
        }

    }
}
