<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'Admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Dosen',
                'email' => 'Dosen@gmail.com',
                'password' => bcrypt('dosen123'),
                'role' => 'Dosen',
            ],
            [
                'name' => 'mahasiswa',
                'email' => 'mahasiswa@gmail.com',
                'password' => bcrypt('mahasiswa'),
                'role' => 'Mahasiswa',
            ],

        ];

        User::insert($users);

    }
}
