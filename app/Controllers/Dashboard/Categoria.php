<?php

namespace App\Controllers\Dashboard;

use App\Models\CategoriaModel;
use App\Controllers\BaseController;

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
        return view('dashboard/categoria/index', $data);
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
        return view('dashboard/categoria/show', $data);
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
        return view('dashboard/categoria/new', $data);
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
            session()->setFlashdata("mensaje", "Se ha creado la categoría " . $this->request->getPost("titulo"));
            return redirect()->to("/dashboard/categoria");
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
        return view('dashboard/categoria/edit', $data);
    } 

    // process form to update a resource
    public function update($id)//: string
    {   
        $categoriaModel = new categoriaModel();
    
        $data = [
            'titulo' => $this->request->getPost("titulo"),
        ];
        $categoria = $categoriaModel->find($id); 
        $result = $categoriaModel->update($id, $data);
        if($result) {
            session()->setFlashdata("mensaje", "La categoría " . $categoria["titulo"] . " pasó a llamarse " . $this->request->getPost("titulo"));
            return redirect()->to("/dashboard/categoria");
        }
    }   
    
    // delete a resource
    public function delete($id)//: string
    {   
        $categoriaModel = new categoriaModel(); 
        $categoria = $categoriaModel->find($id); 
        $result = $categoriaModel->delete($id);
        if($result) {
            session()->setFlashdata("mensaje", "Se ha eliminado la categoría " . $categoria["titulo"]);
            return redirect()->back();
        }
    }   
}