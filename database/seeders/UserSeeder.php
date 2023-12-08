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
        //     'role_id' => 1,
        // ]);
        // User::create([
        //     'nom' => '  Toure',
        //     'prenom' => 'Rokhaya',
        //     'email' => 'rokhaya@gmail.com',
        //     'password' => Hash::make('1111'),
        //     'role_id' => 2,
        // ]);
        // User::create([
        //     'nom' => 'Camar',
        //     'prenom' => 'Mamadou',
        //     'email' => 'mamadou@gmail.com',
        //     'password' => Hash::make('1111'),
        //     'role_id' => 3,
        // ]);
     $users = [
    [
        'nom' => 'Gueye',
        'prenom' => 'Adama',
        'email' => 'adamagu99@gmail.com',
        'password' => Hash::make('adamagueye'),
        'role_id' => 1,
    ],
    [
        'nom' => 'Toure',
        'prenom' => 'Rokhaya',
        'email' => 'rokhaya@gmail.com',
        'password' => Hash::make('1111'),
        'role_id' => 2,
    ],
    [
        'nom' => 'Camar',
        'prenom' => 'Mamadou',
        'email' => 'mamadou@gmail.com',
        'password' => Hash::make('1111'),
        'role_id' => 3,
    ],
];
foreach ($users as $key => $user) {
    User::create($user);
}

    }
}
