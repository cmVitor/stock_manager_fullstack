<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Vitor Martins',
                'email' => 'vitor@gmail.com',
                'cpf' => '70223402184',
                'role' => 'admin',
                'password' => Hash::make('vitor123'),
                'address_id' => 1
            ],
            [
                'name' => 'Usuario Teste',
                'email' => 'teste@email.com',
                'cpf' => '12345678901',
                'role' => 'admin',
                'password' => Hash::make('teste123'),
                'address_id' => 1
            ]
        ]);
    }
}
