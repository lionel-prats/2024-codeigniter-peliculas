<?php

namespace App\Models;

use CodeIgniter\Model;

// php spark make:model PeliculaImagenModel (v107)
class PeliculaImagenModel extends Model
{
    protected $table = 'pelicula_imagen';
    protected $allowedFields = ["pelicula_id", "imagen_id"];

    protected $returnType = "object";
}
