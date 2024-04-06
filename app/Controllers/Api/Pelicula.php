<?php

namespace App\Controllers\Api;

use App\Models\PeliculaModel;
use CodeIgniter\RESTful\ResourceController;

class Pelicula extends ResourceController 
{
    // instancia de PeliculaModel
    protected $modelName = "App\Models\PeliculaModel";

    // defino en que formato se van a exponer los datos de los endpoints que maneja este controlador
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
            $id = $this->model->insert($data, true); 
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

                // // para las peticiones PATCH|PUT el metodo getPost($nombre_parametro) no funciona
                // 'titulo' => $this->request->getPost("titulo"),
                // 'descripcion' => $this->request->getPost("descripcion"),

                // el tratarse de una peticion PATCH|PUT esta es la forma correcta de acceder a los parametros que se envian en el body de la peticion, para que el UPDATE funcione correctamente (v95)
                'titulo' => $this->request->getRawInputVar('titulo'),
                'descripcion' => $this->request->getRawInput()["descripcion"],
            ];
            
            $id = $this->model->update($id, $data);
            // $result = $peliculaModel->update($id, $data);

        } else {
            
            // // forma de mandar los errores individualmente y no todos juntos (v96)
            // if($this->validator->getError("titulo")) {
            //     return $this->respond($this->validator->getErrors(), 400);
            // }
            // if($this->validator->getError("descripcion")) {
            //     return $this->respond($this->validator->getErrors(), 400);
            // }
        
            // en la propiedad $codes del trait ResponseTrait tenemos el listado de errores HTTP para consultar (v94)
            return $this->respond($this->validator->getErrors(), 400);
        }
        // return $this->respond($this->request->getRawInput()["descripcion"]);
        return $this->respond($id);
    }   

    // DELETE /api/pelicula/(.*)
    public function delete($id = null)//: string
    {   
        // $peliculaModel = new PeliculaModel();    
        // $result = $peliculaModel->delete($id);
        
        $id = $this->model->delete($id);
        return $this->respond($id);
    }   
}