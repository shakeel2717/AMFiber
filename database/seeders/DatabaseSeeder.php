<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Shakeel Ahmad',
            'email' => 'shakeel2717@gmail.com',
            'password' => bcrypt("asdfasdf")
        ]);

        \App\Models\Party::factory()->create([
            'name' => 'Customer Account 1',
            'phone' => '1234567890',
            'address' => 'AMFiber House, Sector 63, Noida, UP',
            'type' => 'customer',
        ]);

        \App\Models\Party::factory()->create([
            'name' => 'Customer Account 2',
            'phone' => '1234567890',
            'address' => 'AMFiber House, Sector 63, Noida, UP',
            'type' => 'customer',
        ]);

        \App\Models\Party::factory()->create([
            'name' => 'Customer Account 3',
            'phone' => '1234567890',
            'address' => 'AMFiber House, Sector 63, Noida, UP',
            'type' => 'customer',
        ]);

        \App\Models\Party::factory()->create([
            'name' => 'Vendor Account 1',
            'phone' => '1234567890',
            'address' => 'AMFiber House, Sector 63, Noida, UP',
            'type' => 'vendor',
        ]);

        \App\Models\Party::factory()->create([
            'name' => 'Vendor Account 2',
            'phone' => '1234567890',
            'address' => 'AMFiber House, Sector 63, Noida, UP',
            'type' => 'vendor',
        ]);

        for ($i = 1; $i < 38; $i++) {


            if ($i == 24 || $i == 27) {
                continue;
            }

            \App\Models\Product::factory()->create([
                'name' => 'AM-' . $i,
                'price' => Arr::random([100, 200, 300, 400, 500]),
                'description' => 'Product Description for AM-' . $i,
                'image' => $i . '.jpg',
            ]);
        }


    }
}
