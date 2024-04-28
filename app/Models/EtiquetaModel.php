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

    /**
     * retorna el titulo de la categoria asociada a una etiqueta
     *
     * @param int $id e.id
     * @return string retorna el titulo de la categoria asociada a la etiqueta recibida por parametro
    */
    public function getCategoryTag($id)
    {
        /* 
        SELECT e.id, e.titulo, c.titulo 
        FROM etiquetas e
        LEFT JOIN categorias c ON c.id = e.categoria_id 
        WHERE e.id = 8 
        */
        // return $this->select("e.id, e.titulo, c.titulo")
        $response =  $this->select("c.titulo")
            ->join("categorias c", "c.id = etiquetas.categoria_id", "LEFT")
            ->where("etiquetas.id", $id)
            ->find();

        return $response[0]->titulo;
    }

    /**
     * retorna todos los registros de la tabla etiquetas, filtrando por el campo y valor recibidos por parametro
     *
     * @param int $field campo de la tabla etiquetas
     * @param int $value valor buscado
     * @return array retorna un array indexado de objetos donde cada objeto es un registro de la tabla etiquetas asociado a la pelicula buscada
    */
    public function getTagsByField($field, $value)
    {
        return $this->select("etiquetas.*")
            ->where("etiquetas.$field", $value)
            ->findAll();
    }
}
