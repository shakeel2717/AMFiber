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

        for ($i = 1; $i < 38; $i++) {


            if ($i == 24 || $i == 27) {
                continue;
            }

            \App\Models\Product::factory()->create([
                'name' => 'AM-' . $i,
                'price' => Arr::random([10, 20, 30, 40, 50]),
                'description' => 'Product Description for AM-' . $i,
                'image' => $i . '.jpg',
            ]);
        }


    }
}
