<?php

namespace App\Models;

use CodeIgniter\Model;

// php spark make:model EtiquetaModel (v109)
class EtiquetaModel extends Model
{
    protected $table = 'etiquetas';
    protected $primaryKey = 'id';
    protected $allowedFields = ["titulo", "categoria_id"];
    protected $returnType = "object";

    
}
