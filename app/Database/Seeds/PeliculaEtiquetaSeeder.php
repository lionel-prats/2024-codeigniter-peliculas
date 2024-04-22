<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeliculaEtiquetaSeeder extends Seeder
{
    public function run()
    {
        $this->db->table("pelicula_etiqueta")->where("pelicula_id >=", 1)->delete();
    }
}
