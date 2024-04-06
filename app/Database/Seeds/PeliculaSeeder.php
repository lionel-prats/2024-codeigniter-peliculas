<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeliculaSeeder extends Seeder
{
    public function run()
    {
        // Eliminar todos los registros de la tabla
        $this->db->table("peliculas")->truncate();

        // Crear 20 nuevos registros
        for ($i = 0; $i < 60; $i++) { 
            $this->db->table("peliculas")->insert([
                "titulo" => "Pelicula " . $i + 1,
                "descripcion" => "Descripción de la película " . $i + 1
            ]);
        }
    }
}