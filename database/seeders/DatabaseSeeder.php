<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Plai;
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
            'name' => 'Asan Webs',
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
                'description' => 'Product Description for AM-' . $i,
                'image' => $i . '.jpg',
            ]);
        }

        // adding plais
        $plai = new Plai();
        $plai->name = 'Single';
        $plai->price = '100';
        $plai->save();

        // adding plais
        $plai = new Plai();
        $plai->name = '1.5';
        $plai->price = '120';
        $plai->save();

        // adding plais
        $plai = new Plai();
        $plai->name = 'Double';
        $plai->price = '140';
        $plai->save();

        // adding plais
        $plai = new Plai();
        $plai->name = 'Color Double';
        $plai->price = '150';
        $plai->save();

        // adding plais
        $plai = new Plai();
        $plai->name = '3';
        $plai->price = '210';
        $plai->save();

    }
}
