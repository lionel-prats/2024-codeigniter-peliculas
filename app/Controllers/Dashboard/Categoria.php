<?php

namespace App\Controllers\Dashboard;

use App\Models\CategoriaModel;
use App\Controllers\BaseController;

class Categoria extends BaseController
{
    // list all resources
    public function index(): string
    {

        // session()->destroy();

        // echo "<pre>";
        // var_dump(session("usuario"));
        // echo "</pre>";
        // exit;
        // echo json_encode(session("usuario"));

        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->paginate(5);//->findAll();
        $data = [
            "tituloVista" => "Listado de categorías",
            "categorias" => $categorias,
            'pager' => $categoriaModel->pager,
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
        if($this->validate("categorias")){
            $categoriaModel = new CategoriaModel();
            $data = [
                'titulo' => $this->request->getPost("titulo"),
            ];
            $result = $categoriaModel->insert($data, false);
            if($result) {
                // $newId = $categoriaModel->getInsertID();
                $message = "Se ha creado la categoría <strong>" . $this->request->getPost("titulo") . "</strong>";
                session()->setFlashdata("mensaje", $message);
                return redirect()->to("/dashboard/categoria")->with("alert-bg", "alert-success");
            } else {
                echo "error";
            }
        } else {
            session()->setFlashdata([
                // "validation" => $this->validator->listErrors()
                "validation" => $this->validator->getErrors()
            ]);
            return redirect()->back()->withInput();
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
        if($this->validate("categorias")){
            $categoriaModel = new categoriaModel();
            $data = [
                'titulo' => $this->request->getPost("titulo"),
            ];
            $categoria = $categoriaModel->find($id); 
            $result = $categoriaModel->update($id, $data);
            if($result) {
                $message = "La categoría <strong>" . $categoria->titulo . "</strong> pasó a llamarse <b>" . $this->request->getPost("titulo") . "</b>";
                session()->setFlashdata("mensaje", $message);
                return redirect()->to("/dashboard/categoria")->with("alert-bg", "alert-success");
            }
        } else {
            session()->setFlashdata([
                // "validation" => $this->validator->listErrors()
                "validation" => $this->validator->getErrors()
            ]);
            return redirect()->back()->withInput();
        }
    }   
    
    // delete a resource
    public function delete($id)//: string
    {   
        $categoriaModel = new categoriaModel(); 
        $categoria = $categoriaModel->find($id); 
        $result = $categoriaModel->delete($id);
        if($result) {
            $message = "Se ha eliminado la categoría <strong>" . $categoria->titulo . "</strong>";
            session()->setFlashdata("mensaje", $message);
            return redirect()->back()->with("alert-bg", "alert-danger");
        }
    }   
}