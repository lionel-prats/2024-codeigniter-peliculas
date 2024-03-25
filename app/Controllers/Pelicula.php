<?php

namespace App\Controllers;

use App\Models\PeliculaModel;

class Pelicula extends BaseController
{
    // list all resources
    public function index(): string
    {
        $peliculaModel = new PeliculaModel();
        $peliculas = $peliculaModel->findAll();
        $data = [
            "tituloVista" => "Listado de películas",
            "peliculas" => $peliculas,
        ];
        return view('pelicula/index', $data);
    }   

    // list a single resource
    public function show($id): string
    {
        $peliculaModel = new PeliculaModel();
        $pelicula = $peliculaModel->find($id);
        $data = [
            "tituloVista" => "Detalle Película",
            "pelicula" => $pelicula,
        ];
        return view('pelicula/show', $data);
    }   

    // render form to create new resource
    public function new(): string
    {
        $data = [
            "tituloVista" => "Crear Película",
            "op" => "Create",
            "pelicula" => [
                "titulo" => "",
                "descripcion" => "",
            ],
        ];
        return view('pelicula/new', $data);
    }   
    
    // process form to create new resource
    public function create()//: string
    {   
        $peliculaModel = new PeliculaModel();
    
        $data = [
            'titulo' => $this->request->getPost("titulo"),
            'descripcion' => $this->request->getPost("descripcion"),
        ];
        
        $result = $peliculaModel->insert($data, false);
        
        if($result) {
            $newId = $peliculaModel->getInsertID();
            echo "La película '" . $this->request->getPost("titulo") . "' se ha creado correctamente con el id $newId.";
        } else {
            echo "error";
        }
    }   

    // render form to edit a resource
    public function edit($id): string
    {
        $peliculaModel = new PeliculaModel();
        $pelicula = $peliculaModel->find($id);
        $data = [
            "tituloVista" => "Editar Película",
            "op" => "Update",
            "pelicula" => $pelicula,
        ];
        return view('pelicula/edit', $data);
    } 

    // process form to update a resource
    public function update($id)//: string
    {   
        $peliculaModel = new PeliculaModel();
    
        $data = [
            'titulo' => $this->request->getPost("titulo"),
            'descripcion' => $this->request->getPost("descripcion"),
        ];
        
        $result = $peliculaModel->update($id, $data);
        var_dump($result);
    }   
    
    // delete a resource
    public function delete($id)//: string
    {   
        $peliculaModel = new PeliculaModel();    
        $result = $peliculaModel->delete($id);
        var_dump($result);
    }   
}