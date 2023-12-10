<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'nom' => 'Gueye',
        //     'prenom' => 'Adama',
        //     'email' => 'adamagu99@gmail.com',
        //     'password' => Hash::make('adamagueye'),
        //     'role' => 1,
        // ]);
        // User::create([
        //     'nom' => '  Toure',
        //     'prenom' => 'Rokhaya',
        //     'email' => 'rokhaya@gmail.com',
        //     'password' => Hash::make('1111'),
        //     'role' => 2,
        // ]);
        // User::create([
        //     'nom' => 'Camar',
        //     'prenom' => 'Mamadou',
        //     'email' => 'mamadou@gmail.com',
        //     'password' => Hash::make('1111'),
        //     'role' => 3,
        // ]);
     $users = [
    [
        'image' => null,
        'nom' => 'Gueye',
        'prenom' => 'Adama',
        'email' => 'adamagu99@gmail.com',
        'password' => Hash::make('adamagueye'),
        'role' => 'admin',
    ],
    [
        'image' => null,
        'nom' => 'Toure',
        'prenom' => 'Rokhaya',
        'email' => 'rokhaya@gmail.com',
        'password' => Hash::make('1111'),
        'role' => 'experimente',
    ],
    [
        'image' => null,
        'nom' => 'Camar',
        'prenom' => 'Mamadou',
        'email' => 'mamadou@gmail.com',
        'password' => Hash::make('1111'),
        'role' => 'novice',
    ],
];
foreach ($users as $key => $user) {
    User::create($user);
}

    }
}
