<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            ['id' => 1, 'name' => 'Norte'],
            ['id' => 2, 'name' => 'Nordeste'],
            ['id' => 3, 'name' => 'Sudeste'],
            ['id' => 4, 'name' => 'Sul'],
            ['id' => 5, 'name' => 'Centro-Oeste'],
        ]);
    }
}
