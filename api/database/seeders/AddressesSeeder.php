<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('addresses')->insert([
            [
                'logradouro' => 'Rua c-137',
                'number' => 396,
                'complemento' => 'casa03',
                'city_id' => 3,
                'bairro' => 'Jardim América',
                'cep' => '74275060',
            ],
        ]);
    }
}
