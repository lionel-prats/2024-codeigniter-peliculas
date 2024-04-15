<?php

namespace App\Models;

use CodeIgniter\Model;

// php spark make:model PeliculaModel (v?)
class PeliculaModel extends Model
{
    protected $table = 'peliculas';
    protected $primaryKey = 'id';
    protected $allowedFields = ["titulo", "descripcion", "categoria_id"];
    protected $returnType = "object";

    // $this->db->get_compiled_select();
    // $this->db->getCompiledSelect();

    /**
     * retorna informacion de todas las imagenes asociadas a una pelicula
     *
     * @param int $id peliculas.id
     * @return array retorna un array indexado de objetos donde cada objeto es un registro de la tabla imagenes asociado a la pelicula buscada
    */
    public function getImagesById($id)
    {
        return $this->select("i.*")
            ->join("pelicula_imagen pi", "pi.pelicula_id = peliculas.id")
            ->join("imagenes i", "i.id = pi.imagen_id")
            ->where("pi.pelicula_id", $id)
            ->orderBy("i.id")
            ->findAll();
            // ->find();
    }
    
    /**
     * retorna informacion de todas las etiquetas asociadas a una pelicula
     *
     * @param int $id peliculas.id
     * @return array retorna un array indexado de objetos donde cada objeto es un registro de la tabla etiquetas asociado a la pelicula buscada
    */
    public function getEtiquetasById($id)
    {
        return $this->select("e.*")
            ->join("pelicula_etiqueta PE", "PE.pelicula_id = peliculas.id")
            ->join("etiquetas E", "E.id = PE.etiqueta_id")
            ->where("peliculas.id", $id)
            ->orderBy("E.id")
            ->findAll();
        // $this->db->get_compiled_select();
        // $this->db->getCompiledSelect();
    }

    

}