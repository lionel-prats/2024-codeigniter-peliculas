<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeliculaImagenSeeder extends Seeder
{
    public function run()
    {
        $this->db->table("pelicula_imagen")->where("pelicula_id >=", 1)->delete();
    }
}
