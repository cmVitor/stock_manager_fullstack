<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->insert([
            ['codigouf' => 12, 'name' => 'Acre', 'uf' => 'AC', 'region' => 1],
            ['codigouf' => 27, 'name' => 'Alagoas', 'uf' => 'AL', 'region' => 2],
            ['codigouf' => 16, 'name' => 'Amapá', 'uf' => 'AP', 'region' => 1],
            ['codigouf' => 13, 'name' => 'Amazonas', 'uf' => 'AM', 'region' => 1],
            ['codigouf' => 29, 'name' => 'Bahia', 'uf' => 'BA', 'region' => 2],
            ['codigouf' => 23, 'name' => 'Ceará', 'uf' => 'CE', 'region' => 2],
            ['codigouf' => 53, 'name' => 'Distrito Federal', 'uf' => 'DF', 'region' => 5],
            ['codigouf' => 32, 'name' => 'Espírito Santo', 'uf' => 'ES', 'region' => 3],
            ['codigouf' => 52, 'name' => 'Goiás', 'uf' => 'GO', 'region' => 5],
            ['codigouf' => 21, 'name' => 'Maranhão', 'uf' => 'MA', 'region' => 2],
            ['codigouf' => 51, 'name' => 'Mato Grosso', 'uf' => 'MT', 'region' => 5],
            ['codigouf' => 50, 'name' => 'Mato Grosso do Sul', 'uf' => 'MS', 'region' => 5],
            ['codigouf' => 31, 'name' => 'Minas Gerais', 'uf' => 'MG', 'region' => 3],
            ['codigouf' => 15, 'name' => 'Pará', 'uf' => 'PA', 'region' => 1],
            ['codigouf' => 25, 'name' => 'Paraíba', 'uf' => 'PB', 'region' => 2],
            ['codigouf' => 41, 'name' => 'Paraná', 'uf' => 'PR', 'region' => 4],
            ['codigouf' => 26, 'name' => 'Pernambuco', 'uf' => 'PE', 'region' => 2],
            ['codigouf' => 22, 'name' => 'Piauí', 'uf' => 'PI', 'region' => 2],
            ['codigouf' => 33, 'name' => 'Rio de Janeiro', 'uf' => 'RJ', 'region' => 3],
            ['codigouf' => 24, 'name' => 'Rio Grande do Norte', 'uf' => 'RN', 'region' => 2],
            ['codigouf' => 43, 'name' => 'Rio Grande do Sul', 'uf' => 'RS', 'region' => 4],
            ['codigouf' => 11, 'name' => 'Rondônia', 'uf' => 'RO', 'region' => 1],
            ['codigouf' => 14, 'name' => 'Roraima', 'uf' => 'RR', 'region' => 1],
            ['codigouf' => 42, 'name' => 'Santa Catarina', 'uf' => 'SC', 'region' => 4],
            ['codigouf' => 35, 'name' => 'São Paulo', 'uf' => 'SP', 'region' => 3],
            ['codigouf' => 28, 'name' => 'Sergipe', 'uf' => 'SE', 'region' => 2],
            ['codigouf' => 17, 'name' => 'Tocantins', 'uf' => 'TO', 'region' => 1],
        ]);
    }
}
