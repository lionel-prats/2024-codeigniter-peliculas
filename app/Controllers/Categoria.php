<?php

namespace App\Controllers;

use App\Models\CategoriaModel;

class Categoria extends BaseController
{
    // list all resources
    public function index(): string
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll();
        $data = [
            "tituloVista" => "Listado de categorías",
            "categorias" => $categorias,
        ];
        return view('categoria/index', $data);
    }   

    // list a single resource
    public function show($id): string
    {
        $categoriaModel = new CategoriaModel();
        $categoria = $categoriaModel->find($id);
        $data = [
            "tituloVista" => "Detalle Categoría",
            "categoria" => $categoria,
        ];
        return view('categoria/show', $data);
    }   

    // render form to create new resource
    public function new(): string
    {
        $data = [
            "tituloVista" => "Crear Categoría",
            "op" => "Create",
            "categoria" => [
                "titulo" => "",
            ],
        ];
        return view('categoria/new', $data);
    }   
    
    // process form to create new resource
    public function create()//: string
    {   
        $categoriaModel = new CategoriaModel();
    
        $data = [
            'titulo' => $this->request->getPost("titulo"),
        ];
        
        $result = $categoriaModel->insert($data, false);
        
        if($result) {
            $newId = $categoriaModel->getInsertID();
            echo "La categoría '" . $this->request->getPost("titulo") . "' se ha creado correctamente con el id $newId.";
        } else {
            echo "error";
        }
    }   

    // render form to edit a resource
    public function edit($id): string
    {
        $categoriaModel = new CategoriaModel();
        $categoria = $categoriaModel->find($id);
        $data = [
            "tituloVista" => "Editar Categoría",
            "op" => "Update",
            "categoria" => $categoria,
        ];
        return view('categoria/edit', $data);
    } 

    // process form to update a resource
    public function update($id)//: string
    {   
        $categoriaModel = new categoriaModel();
    
        $data = [
            'titulo' => $this->request->getPost("titulo"),
        ];
        
        $result = $categoriaModel->update($id, $data);
        var_dump($result);
    }   
    
    // delete a resource
    public function delete($id)//: string
    {   
        $categoriaModel = new categoriaModel();    
        $result = $categoriaModel->delete($id);
        var_dump($result);
    }   
}