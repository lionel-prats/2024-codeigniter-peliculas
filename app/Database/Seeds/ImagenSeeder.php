<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImagenSeeder extends Seeder
{
    public function run()
    {
        $this->db->table("imagenes")->where("id >=", 1)->delete();
        $this->db->query("ALTER TABLE imagenes AUTO_INCREMENT = 1");
    }
}
