<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

// "php spark db:seed MainSeeder" para correr este seeder
class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call("CategoriaSeeder");
        $this->call("PeliculaSeeder");
        $this->call("EtiquetaSeeder");
    }
}
