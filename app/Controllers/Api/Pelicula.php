<?php

namespace App\Controllers\Api;

use App\Models\PeliculaModel;
use CodeIgniter\RESTful\ResourceController;

class Pelicula extends ResourceController 
{
    // instancia de PeliculaModel
    protected $modelName = "App\Models\PeliculaModel";

    protected $format = "json"; // codeigniter tambien soporta xml 
    // protected $format = "xml"; 

    // GET /api/pelicula
    public function index() 
    {
        // model es una propiedad de la clase abstracta BaseResource, de la cual hereda ResourceController, y de la cual hereda este controlador que a partir de la proiedad $modelName definida mas arriba, es una instancia de PeliculaModel (v93)
        return $this->respond($this->model->findAll());    
    }
    
    // GET /api/pelicula/(.*)
    public function show($id = null) 
    {
        return $this->respond($this->model->find($id));    
    }
  
    // POST /api/pelicula/create
    public function create() 
    {
        // $peliculaModel = new PeliculaModel();

        // $this->validate("peliculas") es referencia a Validation::peliculas (/app/Config/Validation.php)
        if($this->validate("peliculas")){
            $data = [
                'titulo' => $this->request->getPost("titulo"),
                'descripcion' => $this->request->getPost("descripcion"),
            ];
            $id = $this->model->insert($data, false); 
            // $result = $peliculaModel->insert($data, false); 
        
        } else {
            // en la propiedad $codes del trait ResponseTrait tenemos el listado de errores HTTP para consultar (v94)
            return $this->respond($this->validator->getErrors(), 400);
        }
        return $this->respond($id);
    }

    // PATCH|PUT /api/pelicula/(.*)
    public function update($id = null)//: string
    {   
        // $peliculaModel = new PeliculaModel();

        if($this->validate("peliculas")){
            $data = [
                'titulo' => $this->request->getPost("titulo"),
                'descripcion' => $this->request->getPost("descripcion"),
            ];
            
            $id = $this->model->update($id, $data);
            // $result = $peliculaModel->update($id, $data);

        } else {
            // en la propiedad $codes del trait ResponseTrait tenemos el listado de errores HTTP para consultar (v94)
            return $this->respond($this->validator->getErrors(), 400);
        }
        return $this->respond($id);
    }   

    // DELETE /api/pelicula/(.*)
    public function delete($id = null)//: string
    {   
        // $peliculaModel = new PeliculaModel();    
        // $result = $peliculaModel->delete($id);
        
        $this->model->delete($id);
        return $this->respond("ok");
    }   
}