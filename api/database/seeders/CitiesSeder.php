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
            ['codigo' => '1100205', 'name' => 'Porto Velho', 'uf' => 'RO'],
            ['codigo' => '1200401', 'name' => 'Rio Branco', 'uf' => 'AC'],
            ['codigo' => '1302603', 'name' => 'Manaus', 'uf' => 'AM'],
            ['codigo' => '1400100', 'name' => 'Boa Vista', 'uf' => 'RR'],
            ['codigo' => '1501402', 'name' => 'Belém', 'uf' => 'PA'],
            ['codigo' => '1600303', 'name' => 'Macapá', 'uf' => 'AP'],
            ['codigo' => '1721000', 'name' => 'Palmas', 'uf' => 'TO'],
            ['codigo' => '2111300', 'name' => 'São Luís', 'uf' => 'MA'],
            ['codigo' => '2211001', 'name' => 'Teresina', 'uf' => 'PI'],
            ['codigo' => '2304400', 'name' => 'Fortaleza', 'uf' => 'CE'],
            ['codigo' => '2408102', 'name' => 'Natal', 'uf' => 'RN'],
            ['codigo' => '2507507', 'name' => 'João Pessoa', 'uf' => 'PB'],
            ['codigo' => '2611606', 'name' => 'Recife', 'uf' => 'PE'],
            ['codigo' => '2800308', 'name' => 'Aracaju', 'uf' => 'SE'],
            ['codigo' => '3106200', 'name' => 'Belo Horizonte', 'uf' => 'MG'],
            ['codigo' => '3205309', 'name' => 'Vitória', 'uf' => 'ES'],
            ['codigo' => '4106902', 'name' => 'Curitiba', 'uf' => 'PR'],
            ['codigo' => '4205407', 'name' => 'Florianópolis', 'uf' => 'SC'],
            ['codigo' => '4314902', 'name' => 'Porto Alegre', 'uf' => 'RS'],
            ['codigo' => '5002704', 'name' => 'Campo Grande', 'uf' => 'MS'], 
            ['codigo' => '5103403', 'name' => 'Cuiabá', 'uf' => 'MT'], 
            ['codigo' => '5300108', 'name' => 'Brasília', 'uf' => 'DF'], 
        ]);
    }
}
