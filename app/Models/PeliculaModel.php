<?php

namespace App\Models;

use CodeIgniter\Model;

class PeliculaModel extends Model
{
    protected $table = 'peliculas';
    protected $primaryKey = 'id';
    protected $allowedFields = ["titulo", "descripcion", "categoria_id"];

    protected $returnType = "object";

    // $useSoftDeletes
    // $useTimestamps
    // $createdField
    // $updatedField

    // $this->db->get_compiled_select();
    // $this->db->getCompiledSelect();

}
