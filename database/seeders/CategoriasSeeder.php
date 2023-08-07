<?php

namespace Database\Seeders;

use App\Models\Categorias;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nome' => 'Admin',
            ],
            [
                'nome' => 'Gerente',
            ],
            [
                'nome' => 'Normal',
            ]
        ];

        foreach($categorias as $categoria){
            Categorias::create($categoria);
        }
    }
}
