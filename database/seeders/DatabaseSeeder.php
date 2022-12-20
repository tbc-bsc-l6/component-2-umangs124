<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ProductType;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        ProductType::create([
            'name' => 'Book'
        ]);
        ProductType::create([
            'name' => 'CD'
        ]);
        ProductType::create([
            'name' => 'Game'
        ]);

        Role::create([
            'name' => 'Vendor'
        ]);
        Role::create([
            'name' => 'Admin'
        ]);
    }
}
