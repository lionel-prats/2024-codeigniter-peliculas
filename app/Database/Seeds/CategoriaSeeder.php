<?php

namespace App\Database\Seeds;

use App\Models\CategoriaModel;
use CodeIgniter\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        // $categoriaModel = new CategoriaModel();

        // // Returns a non-shared new instance of the query builder for this connection.
        // $this->db->table("categorias");

        $this->db->table("categorias")->where("id >=", 1)->delete();

        // Restablecer el autoincremental a 1
        $this->db->query("ALTER TABLE categorias AUTO_INCREMENT = 1");

        // creo 10 categorias fake (v100)
        for ($i=0; $i < 10; $i++) { 
            $this->db->table("categorias")->insert([
                "titulo" => "Categoria " . $i+1
            ]);
        }
    }

    /* public function run()
    {
        // Eliminar todos los registros de la tabla
        $this->db->table("categorias")->truncate();

        // // Restablecer el autoincremental a 1
        // $this->db->query("ALTER TABLE categorias AUTO_INCREMENT = 1");

        // Crear 20 nuevos registros
        for ($i = 0; $i < 15; $i++) { 
            $this->db->table("categorias")->insert([
                "titulo" => "Categoria " . $i + 1
            ]);
        }
    } */
}
