<?php

namespace App\Database\Seeds;

use App\Models\CategoriaModel;
use CodeIgniter\Database\Seeder;

// php spark make:seeder EtiquetaSeeder (v109)
// "php spark db:seed EtiquetaSeeder" para correr este seeder
class EtiquetaSeeder extends Seeder
{
    public function run()
    {
        $this->db->table("etiquetas")->where("id >=", 1)->delete();

        // Restablecer el autoincremental a 1
        $this->db->query("ALTER TABLE etiquetas AUTO_INCREMENT = 1");

        $categoriaModel = new CategoriaModel;
        $categorias = $categoriaModel->select("id, titulo")->find();

        // Crear 50 nuevas etiquetas
        for ($i = 0; $i < 50; $i++) { 
            $index_categorias = array_rand($categorias);
            $this->db->table("etiquetas")->insert([
                "titulo" => "Tag " . ($i + 1) . " - " . $categorias[$index_categorias]->titulo,
                "categoria_id" => $categorias[$index_categorias]->id
            ]);
        }
    }
}
