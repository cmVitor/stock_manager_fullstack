<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementUnitsSeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('measurement_units')->insert([
            ['name' => 'Grama', 'abbreviation' => 'g'],
            ['name' => 'Kilograma', 'abbreviation' => 'kg'],
            ['name' => 'Miligrama', 'abbreviation' => 'mg'],
            ['name' => 'Litro', 'abbreviation' => 'L'],
            ['name' => 'Mililitro', 'abbreviation' => 'mL'],
            ['name' => 'Centilitro', 'abbreviation' => 'cL'],
            ['name' => 'Unidade', 'abbreviation' => 'un'],
            ['name' => 'Pacote', 'abbreviation' => 'pct'],
            ['name' => 'Fatia', 'abbreviation' => 'fatia'],
            ['name' => 'Colher de chá', 'abbreviation' => 'cchá'],
            ['name' => 'Colher de sopa', 'abbreviation' => 'csopa'],
            ['name' => 'Xícara', 'abbreviation' => 'xic'],
            ['name' => 'Pedaço', 'abbreviation' => 'pç'],
            ['name' => 'Lata', 'abbreviation' => 'lata'],
            ['name' => 'Garrafa', 'abbreviation' => 'gar'],
            ['name' => 'Saco', 'abbreviation' => 'saco'],
            ['name' => 'Porção', 'abbreviation' => 'por'],
            ['name' => 'Pote', 'abbreviation' => 'pto'],
            ['name' => 'Caixa', 'abbreviation' => 'cx'],
        ]);
    }
}
