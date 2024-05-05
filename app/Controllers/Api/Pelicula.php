<?php

namespace App\Controllers\Api;

// use App\Models\PeliculaModel;
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
        // $this->model refiere a la instancia de PeliculaModel definido en el atributo $modelName, el principio de esta clase 
        return $this->respond($this->model->findAll());    
    }
    
    // GET http://localhost:8080/api/pelicula/paginado?page=40 (v165)
    public function paginado() 
    {
        return $this->respond($this->model->paginate(10));    
    }
    
    // GET http://localhost:8080/api/pelicula/paginado_full?buscar=a+2&etiqueta_id=36&categoria_id=7&page=12 (v166)
    public function paginado_full() 
    {   
        $peliculas = $this->model
            ->select("peliculas.*, C.titulo as categoria, MIN(I.imagen) as imagen")
            ->join("categorias C", "C.id = peliculas.categoria_id", "inner")
            ->join("pelicula_etiqueta PE", "PE.pelicula_id = peliculas.id", "left")
            ->join("etiquetas E", "E.id = PE.etiqueta_id", "left")
            ->join("pelicula_imagen PI", "PI.pelicula_id = peliculas.id", "left")
            ->join("imagenes I", "I.id = PI.imagen_id", "left")
            ->when($this->request->getGet("categoria_id"), static function ($query, $categoria_id) {
                $query->where("peliculas.categoria_id", $categoria_id);
            })
            ->when($this->request->getGet("etiqueta_id"), static function ($query, $etiqueta_id) {
                $query->where('PE.etiqueta_id', $etiqueta_id);
            })
            ->when($this->request->getGet("buscar"), static function ($query, $buscar) {
                $query->groupStart()
                    ->like('peliculas.titulo', $buscar, 'both')
                    ->orlike('peliculas.descripcion', $buscar, 'both')
                ->groupEnd();
            })
            ->groupBy("peliculas.id")
            ->orderBy("peliculas.id")
            ->paginate(3);
        return $this->respond($peliculas);     
    }
    
    // GET http://localhost:8080/api/pelicula/index_categoria_id/4?page=3 (v167)
    public function index_categoria_id($categoria_id) 
    {
        $peliculas = $this->model
            ->select("peliculas.*, C.titulo as categoria, MIN(I.imagen) as imagen")
            ->join("categorias C", "C.id = peliculas.categoria_id", "inner")
            ->join("pelicula_etiqueta PE", "PE.pelicula_id = peliculas.id", "left")
            ->join("etiquetas E", "E.id = PE.etiqueta_id", "left")
            ->join("pelicula_imagen PI", "PI.pelicula_id = peliculas.id", "left")
            ->join("imagenes I", "I.id = PI.imagen_id", "left")
            ->where('peliculas.categoria_id', $categoria_id)
            ->groupBy("peliculas.id")
            ->orderBy("peliculas.id")
            ->paginate(10);
        foreach($peliculas as $pelicula){
            $etiquetas_pelicula = $this->model->getEtiquetasById($pelicula->id);
            $array_etiquetas_pelicula = [];
            foreach ($etiquetas_pelicula as $etiqueta_pelicula) {
                $objeto_etiqueta = new \stdClass();
                $objeto_etiqueta->id = $etiqueta_pelicula->id;
                $objeto_etiqueta->titulo = $etiqueta_pelicula->titulo;
                $array_etiquetas_pelicula[] = $objeto_etiqueta;
            }
            $pelicula->etiquetas = $array_etiquetas_pelicula;
        }
        return $this->respond($peliculas); 
    }

    // GET http://localhost:8080/api/pelicula/index_etiqueta_id/39?page=2 (v168)
    public function index_etiqueta_id($etiqueta_id) 
    {
        $peliculas = $this->model
            ->select("peliculas.*, C.titulo as categoria, MIN(I.imagen) as imagen")
            ->join("categorias C", "C.id = peliculas.categoria_id", "inner")
            ->join("pelicula_etiqueta PE", "PE.pelicula_id = peliculas.id", "inner")
            ->join("etiquetas E", "E.id = PE.etiqueta_id", "inner")
            ->join("pelicula_imagen PI", "PI.pelicula_id = peliculas.id", "left")
            ->join("imagenes I", "I.id = PI.imagen_id", "left")
            ->where('E.id', $etiqueta_id)
            ->groupBy("peliculas.id")
            ->orderBy("peliculas.id")
            ->paginate(1);  
        foreach($peliculas as $pelicula){
            $etiquetas_pelicula = $this->model->getEtiquetasById($pelicula->id);
            $array_etiquetas_pelicula = [];
            foreach ($etiquetas_pelicula as $etiqueta_pelicula) {
                $objeto_etiqueta = new \stdClass();
                $objeto_etiqueta->id = $etiqueta_pelicula->id;
                $objeto_etiqueta->titulo = $etiqueta_pelicula->titulo;
                $array_etiquetas_pelicula[] = $objeto_etiqueta;
            }
            $pelicula->etiquetas = $array_etiquetas_pelicula;
        }
        return $this->respond($peliculas); 
    }

    // GET http://localhost:8080/api/pelicula/1 (v169)
    public function show($id = null) 
    {
        $pelicula = $this->model
            ->select("peliculas.*, C.titulo as categoria")
            ->join("categorias C", "C.id = peliculas.categoria_id", "inner")
            ->find($id);
        $data = [
            "pelicula" => $pelicula,
            "pelicula_imagenes" => $this->model->getImagesById($id),
            "pelicula_etiquetas" => $this->model->getEtiquetasById($id),
        ];
        return $this->respond($data);    
    }
  
    // POST http://localhost:8080/api/pelicula/create (las pruebas se hacen con POSTMAN)
    public function create() 
    {
        // $peliculaModel = new PeliculaModel();
        // $this->validate("peliculas") es referencia a Validation::peliculas (/app/Config/Validation.php)
        if($this->validate("peliculas")){
            $data = [
                'titulo' => $this->request->getPost("titulo"),
                'descripcion' => $this->request->getPost("descripcion"),
                'categoria_id' => $this->request->getPost("categoria_id"),
            ];
            $id = $this->model->insert($data, true); 
            // $result = $peliculaModel->insert($data, false); 
        
        } else {
            // en la propiedad $codes del trait ResponseTrait tenemos el listado de errores HTTP para consultar (v94)
            return $this->respond($this->validator->getErrors(), 400);
        }
        return $this->respond($id);
    }

    // PATCH|PUT http://localhost:8080/api/pelicula/402 (las pruebas se hacen con POSTMAN)
    public function update($id = null)//: string
    {   
        // $peliculaModel = new PeliculaModel();
        if($this->validate("peliculas")){
            $data = [
                // // para las peticiones PATCH|PUT el metodo getPost($nombre_parametro) no funciona
                // 'titulo' => $this->request->getPost("titulo"),
                // 'descripcion' => $this->request->getPost("descripcion"),

                // el tratarse de una peticion PATCH|PUT esta es la forma correcta de acceder a los parametros que se envian en el body de la peticion, para que el UPDATE funcione correctamente (v95)
                'titulo' => $this->request->getRawInputVar("titulo"),
                'descripcion' => $this->request->getRawInput()["descripcion"],
                'categoria_id' => $this->request->getRawInputVar("categoria_id"),
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