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
     * @param int $id_imagen imagenes.id
     * @return array retorna un array indexado de objetos donde cada objeto es un registro de la tabla peliculas asociado a la imagen buscada
    */
    public function getPeliculasById($id_imagen)
    {
        return $this->select("PEL.*")
            ->join("pelicula_imagen PIM", "PIM.imagen_id = imagenes.id")
            ->join("peliculas PEL", "PEL.id = PIM.pelicula_id")
            ->where("PIM.imagen_id", $id_imagen)
            ->orderBy("PEL.id")
            ->find();
    }
    // public function getPeliculasById($id_imagen)
    // {
    //     return $this->select("PEL.*")
    //         ->join("pelicula_imagen PIM", "PIM.imagen_id = imagenes.id")
    //         ->join("peliculas PEL", "PEL.id = PIM.pelicula_id")
    //         ->where("PIM.imagen_id", $id_imagen)
    //         ->orderBy("PEL.id")
    //         ->find();
    // }
}
