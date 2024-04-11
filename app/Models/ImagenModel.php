<?php

namespace App\Models;

use CodeIgniter\Model;

// php spark make:model ImagenModel (v107)
class ImagenModel extends Model
{
    protected $table = 'imagenes';
    protected $primaryKey = 'id';
    protected $allowedFields = ["imagen", "extension", "data"];
    protected $returnType = "object";

    /**
     * retorna informacion de todas las peliculas asociadas a una imagen
     *
     * @param int $id imagenes.id
     * @return array retorna un array indexado de objetos donde cada objeto es un registro de la tabla peliculas asociado a la imgen buscada
    */
    public function getPeliculasById($id)
    {
        return $this->select("p.*")
            ->join("pelicula_imagen pi", "pi.imagen_id = imagenes.id")
            ->join("peliculas p", "p.id = pi.pelicula_id")
            ->where("pi.imagen_id", $id)
            ->orderBy("p.id")
            ->find();
    }
}
