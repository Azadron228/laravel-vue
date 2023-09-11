<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Post::factory(50)->create();
        \App\Models\Comment::factory(50)->create();

        $userData = [
            'username' => 'Jotaro Kujo',
            'email' => 'jojo@gmail.com',
            'bio' => 'jotaojjfow woadjaowd joadawjdoajodjoadjoajod jwadjawo w',
            'password' => Hash::make('password123'),
        ];
        \App\Models\User::create($userData);
    }
}
