<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->delete();

        User::create([
            'nama_user' => 'Kris Owner',
            'email'     => 'owner@example.com',
            'no_hp'     => '081234567890',
            'role'      => 'owner',
            'password'  => Hash::make('password'),
        ]);

        User::create([
            'nama_user' => 'Dino Admin',
            'email'     => 'admin@example.com',
            'no_hp'     => '081111111111',
            'role'      => 'admin',
            'password'  => Hash::make('password'),
        ]);
    }
}
