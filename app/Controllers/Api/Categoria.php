<?php

namespace App\Controllers\Api;

use App\Models\CategoriaModel;
use CodeIgniter\RESTful\ResourceController;

class Categoria extends ResourceController 
{
    protected $modelName = "App\Models\CategoriaModel";
    protected $format = "json";

    // GET /api/categoria
    public function index() 
    {
        return $this->respond($this->model->findAll());    
    }
    
    // GET /api/categoria/(.*)
    public function show($id = null) 
    {
        return $this->respond($this->model->find($id));    
    }
  
    // POST /api/categoria/create
    public function create() 
    {
        if($this->validate("categorias")){
            $data = [
                'titulo' => $this->request->getPost("titulo"),
            ];
            $id = $this->model->insert($data, true);  
        } else {
            return $this->respond($this->validator->getErrors(), 400);
        }
        return $this->respond($id);
    }

    // PATCH|PUT /api/categoria/(.*)
    public function update($id = null)
    {   
        if($this->validate("categorias")){
            $data = [
                'titulo' => $this->request->getRawInputVar('titulo'),
            ];
            $id = $this->model->update($id, $data);
        } else {
            return $this->respond($this->validator->getErrors(), 400);
        }
        return $this->respond($id);
    }   

    // DELETE /api/categoria/(.*)
    public function delete($id = null)
    {   
        $id = $this->model->delete($id);
        return $this->respond($id);
    }   
}