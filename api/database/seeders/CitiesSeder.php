<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            ['codigo' => '3550308', 'name' => 'São Paulo', 'uf' => 'SP'],
            ['codigo' => '3304557', 'name' => 'Rio de Janeiro', 'uf' => 'RJ'],
            ['codigo' => '5208707', 'name' => 'Goiânia', 'uf' => 'GO'],
            ['codigo' => '2933307', 'name' => 'Vitória da Conquista', 'uf' => 'BA'],
        ]);
    }
}
