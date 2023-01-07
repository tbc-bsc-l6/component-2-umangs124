<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
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
        // ProductType::create([
        //     'name' => 'Book'
        // ]);
        // ProductType::create([
        //     'name' => 'CD'
        // ]);
        // ProductType::create([
        //     'name' => 'Game'
        // ]);

        // Role::create([
        //     'name' => 'Vendor'
        // ]);
        // Role::create([
        //     'name' => 'Admin'
        // ]);

       // For Admin
        \App\Models\User::factory()->create([
            'name' => 'Elle Monet Richards',
            'email' => 'elle@gmail.com',
            'password' => bcrypt('Nepal@123'),
            'role_id' => '2'
        ]);
        
        // For Vendor

        $user = \App\Models\User::factory(30)->create();


        
        $user = \App\Models\User::factory()->create([
            'name' => 'Umang Shrestha',
            'email' => 'umangstha124@gmail.com',
            'password' => bcrypt('Nepal@123'),
            'role_id' => '1'
        ]);

        

        Product::factory(30)->create([
            'user_id' => $user->id
        ]);

    }
}
