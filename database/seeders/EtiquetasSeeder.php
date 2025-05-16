<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtiquetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserta las etiquetas relacionadas con las carreras universitarias
        $etiquetas = [
            'Medicina',
            'Ingeniería de Software',
            'Ingeniería Industrial',
            'Ingeniería Civil',
            'Marketing Digital',
            'Enfermería',
            'Veterinaria',
            'Psicología'
        ];

        foreach ($etiquetas as $etiqueta) {
            Etiqueta::create(['nombre' => $etiqueta]);
        }
    }
}
