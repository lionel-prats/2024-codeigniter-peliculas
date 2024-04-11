<?php

namespace App\Models;

use CodeIgniter\Model;

// php spark make:model PeliculaEtiquetaModel (v109)
class PeliculaEtiquetaModel extends Model
{
    protected $table = 'pelicula_etiqueta';
    // protected $allowedFields = ["pelicula_id", "imagen_id"];
    protected $allowedFields = ["pelicula_id", "etiqueta_id"];
    protected $returnType = "object";

    /**
     * verifica si ya existe una etiqueta asociada a una pelicula chequeando en pelicula_etiqueta
     *
     * @param string $movie_id p.id
     * @param string $tag_id e.id
     * @return bool TRUE si el id de etiqueta recibida ya esta asociada a la pelicula, FALSE en caso contrario
    */
    public function existTagForMovie($movie_id, $tag_id)
    {
        $query = $this->select("*")
            ->where("pelicula_id", $movie_id)
            ->where("etiqueta_id", $tag_id)
            ->first();    
        if($query) return true;
        return false;
    } 
}
