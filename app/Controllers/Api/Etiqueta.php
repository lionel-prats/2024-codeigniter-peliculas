<?php

namespace App\Controllers\Api;

use App\Models\CategoriaModel;
use CodeIgniter\RESTful\ResourceController;

// v172
class Etiqueta extends ResourceController 
{
    protected $modelName = "App\Models\EtiquetaModel";
    protected $format = "json";

    // GET http://localhost:8080/api/etiqueta/
    public function index() 
    {
        return $this->respond($this->model->findAll());    
    }
    
    // GET http://localhost:8080/api/etiqueta/50
    public function show($id = null) 
    {
        $etiqueta = $this->model->find($id);
        if($etiqueta){
            return $this->respond($etiqueta);    
        } else {
            return $this->respond([
                "status" => 400,
                "response" => "No existe la etiqueta con id $id.",
            ], 400);
        }
    }
  
    // POST http://localhost:8080/api/etiqueta
    public function create() 
    {
        $status = 400;
        if($this->validate("etiquetas")){
            $titulo = $this->request->getPost("titulo");
            $categoria_id = $this->request->getPost("categoria_id");
            $categoria_model = new CategoriaModel;
            $categoria = $categoria_model->find($categoria_id);
            if($categoria) {
                $data = [
                    'titulo' => $titulo,
                    'categoria_id' => $categoria_id,
                ];
                $id = $this->model->insert($data, true);  
                $response = ["response" => "Se ha creado la etiqueta '$titulo' (id $id)."];
                $status = 200;
            } else {
                $response = ["response" => "No existe la categoría $categoria_id"];
            }
        } else {
            $response = $this->validator->getErrors();
        }
        return $this->respond($response, $status);
    }

    // PATCH|PUT http://localhost:8080/api/etiqueta/$id_etiqueta
    public function update($id = null)
    {   
        $status = 400;
        if($this->validate("etiquetas")){
            $titulo = $this->request->getRawInput()['titulo']; // forma valida
            $categoria_id = $this->request->getRawInputVar("categoria_id"); // forma valida
            $categoria_model = new CategoriaModel;
            $categoria = $categoria_model->find($categoria_id);
            if($categoria) {
                $data = [
                    'titulo' => $titulo,
                    'categoria_id' => $categoria_id,
                ];  
                $this->model->update($id, $data);
                $response = ["response" => "Se ha actualizado la etiqueta $id."];
                $status = 200;
            } else {
                $response = ["response" => "No existe la categoría $categoria_id"];
            }
        } else {
            $response = $this->validator->getErrors();
        }
        return $this->respond($response, $status);
    }   

    // DELETE http://localhost:8080/api/etiqueta/$id_etiqueta
    public function delete($id = null)
    {   
        $status = 400;
        $this->model->delete($id);
        if($this->model->affectedRows()) {
            $response = ["response" => "Se ha eliminado la etiqueta $id."];
            $status = 200;
        } else {
            $response = ["response" => "La etiqueta $id no existe."];
        }
        return $this->respond($response, $status);
    }   
}