<?php

namespace App\Controllers\Dashboard;

use App\Models\EtiquetaModel;
use App\Models\CategoriaModel;
use App\Controllers\BaseController;

helper('globals'); 

class Etiqueta extends BaseController
{
    // list all resources
    public function index(): string
    {
        $etiqueta_model = new EtiquetaModel();
        $etiquetas = $etiqueta_model->findAll();
        $data = [
            "tituloVista" => "Listado de etiquetas",
            "etiquetas" => $etiquetas,
        ];
        return view('dashboard/etiqueta/index', $data);
    }   
    // list a single resource
    public function show($id): string
    {
        $etiquetaModel = new EtiquetaModel();
        $etiqueta = $etiquetaModel->select("etiquetas.id, etiquetas.titulo, c.titulo as categoria_titulo")
            ->join("categorias c", "c.id = etiquetas.categoria_id", "LEFT")
            ->where("etiquetas.id", $id)
            ->first();
        $data = [
            "tituloVista" => "Detalle Etiqueta",
            "etiqueta" => $etiqueta,
        ];
        return view('dashboard/etiqueta/show', $data);
    }   
    // render form to create new resource
    public function new(): string
    {
        $categoriaModel = new CategoriaModel;
        $data = [
            "tituloVista" => "Crear Etiqueta",
            "op" => "Crear",
            "pelicula" => [
                "titulo" => "",
                "descripcion" => "",
            ],
            "categorias" => $categoriaModel->find(),
        ];
        return view('dashboard/etiqueta/new', $data);
    }     
    // process form to create new resource
    public function create()//: string
    {   
        if($this->validate("etiquetas")){
            $etiqueta_model = new etiquetaModel();
            $data = [
                'titulo' => $this->request->getPost("titulo"),
                'categoria_id' => $this->request->getPost("categoria_id"),
            ];
            $result = $etiqueta_model->insert($data, false); 
            if($result) {
                return redirect()->to("/dashboard/etiqueta")->with("mensaje", "Etiqueta creada exitosamente");
            } else {
                echo "error";
            }
        } else {
            $validation = new \stdClass();
            $validation->titulo =  $this->validator->getError("titulo");
            $validation->categoria_id =  $this->validator->getError("categoria_id");
            
            session()->setFlashdata([
                "validation" => $validation
            ]);
            return redirect()->back()->withInput();
        }
    }   
    // render form to edit a resource
    public function edit($id): string
    {
        $etiquetaModel = new EtiquetaModel();
        $categoriaModel = new CategoriaModel;
        $etiqueta = $etiquetaModel->find($id);
        $data = [
            "tituloVista" => "Editar Etiqueta",
            "op" => "Actualizar Etiqueta",
            "etiqueta" => $etiqueta,
            "categorias" => $categoriaModel->find(),
        ];
        return view('dashboard/etiqueta/edit', $data);
    } 
    // process form to update a resource
    public function update($id)//: string
    {   
        if($this->validate("etiquetas")){
            $etiquetaModel = new EtiquetaModel();
            $data = [
                'titulo' => $this->request->getPost("titulo"),
                'categoria_id' => $this->request->getPost("categoria_id"),
            ];
            $result = $etiquetaModel->update($id, $data);
            if($result) {
                return redirect()->to("/dashboard/etiqueta")->with("mensaje", "Etiqueta editada exitosamente");
            }
        } else {
            $validation = new \stdClass();
            $validation->titulo =  $this->validator->getError("titulo");
            $validation->categoria_id =  $this->validator->getError("categoria_id");
            session()->setFlashdata([
                "validation" => $validation
            ]);
            return redirect()->back()->withInput();
        }
    }    
    // delete a resource
    public function delete($id)//: string
    {   
        $etiqueta_model = new EtiquetaModel();    
        $result = $etiqueta_model->delete($id);
        if($result) {
            return redirect()->back()->with("mensaje", "Etiqueta borrada exitosamente");
        }
    }   
}