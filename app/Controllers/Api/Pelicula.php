<?php

namespace App\Controllers\Api;

// use App\Models\PeliculaModel;
use App\Models\ImagenModel;
use App\Models\EtiquetaModel;
use App\Models\PeliculaImagenModel;
use App\Models\PeliculaEtiquetaModel;
use CodeIgniter\RESTful\ResourceController;

class Pelicula extends ResourceController 
{
    protected $modelName = "App\Models\PeliculaModel"; // instancia de PeliculaModel
    protected $format = "json"; // defino en que formato se van a exponer los datos de los endpoints que maneja este controlador
    // protected $format = "xml"; // codeigniter tambien soporta xml 

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
    
    // POST http://localhost:8080/api/pelicula/$id_pelicula/etiquetas (v171)
    /**
     * crea la relación entre una película y una etiqueta
     *
     * @param string $pelicula_id p.id
     * @return string json donde la clave "response" indica el resultado de la accion
    */
    public function etiquetas_post($pelicula_id)
    {   
        $status = 400;
        if($this->validate("pelicula_etiqueta")){
            $etiqueta_id = $this->request->getPost("etiqueta_id");
            $etiqueta_model = new EtiquetaModel;
            $etiqueta_existe = $etiqueta_model->find($etiqueta_id);
            if($etiqueta_existe) {
                $pelicula_etiqueta_model = new PeliculaEtiquetaModel;
                $existe_relacion = $pelicula_etiqueta_model->existTagForMovie($pelicula_id, $etiqueta_id);
                if(!$existe_relacion) {
                    $pelicula_etiqueta_model->save([
                        "pelicula_id" => $pelicula_id,
                        "etiqueta_id" => $etiqueta_id,
                    ]); 
                    $response = ["response" => "Se ha creado la relación entre la película $pelicula_id y la etiqueta $etiqueta_id."];
                    $status = 200;
                } else {
                    $response = ["response" => "La etiqueta $etiqueta_id ya está asociada a la película $pelicula_id."];
                }
            } else {
                $response = ["response" => "La etiqueta $etiqueta_id no existe."];
            }
        } else {
            $response = $this->validator->getErrors();
        }
        return $this->respond($response, $status);
    }

    // DELETE http://localhost:8080/api/pelicula/(:num)/etiqueta/(:num)/delete (v171)
    /**
     * elimina la relación entre una película y una etiqueta
     *
     * @param string $pelicula_id p.id
     * @param string $etiqueta_id e.id
     * @return string json donde la clave "response" indica el resultado de la accion
    */
    public function etiqueta_delete($pelicula_id, $etiqueta_id)
    {   
        $status = 400;
        $pelicula_etiqueta_model = new PeliculaEtiquetaModel;
        $pelicula_etiqueta_model
            ->where("pelicula_id", $pelicula_id)
            ->where("etiqueta_id", $etiqueta_id)
            ->delete();
        if($pelicula_etiqueta_model->affectedRows()) {
            $response = ["response" => "Se ha eliminado la relacion entre la película $pelicula_id y la etiqueta $etiqueta_id."];
            $status = 200;
        } else {
            $response = ["response" => "La relacion entre la película $pelicula_id y la etiqueta $etiqueta_id no existe."];
        }
        return $this->respond($response, $status);
    }

    // POST http://localhost:8080/api/pelicula/$id_pelicula/imagen/upload (v173)
    public function upload($pelicula_id)
    {
        helper("filesystem"); 
        $status = 400;
        if($image_file = $this->request->getFile("imagen")){
            if($image_file->isValid()){
                if($this->validate("imagenes")){ 
                    $imagen_nombre = $image_file->getRandomName();
                    $extension = $image_file->guessExtension();
                    try {
                        $image_file->move("../public/uploads/peliculas", $imagen_nombre);
                        $imagenModel = new ImagenModel();
                        $data = [
                            "imagen" => $imagen_nombre,
                            "extension" => $extension,
                            "data" => json_encode(get_file_info("../public/uploads/peliculas/$imagen_nombre")),
                        ];
                        $imagen_id = $imagenModel->insert($data); 
                        $PeliculaImagenModel = new PeliculaImagenModel();
                        $data = [
                            'pelicula_id' => $pelicula_id,
                            'imagen_id' => $imagen_id,
                        ];
                        $PeliculaImagenModel->insert($data);                         
                        $response = ["response" => "pasó las 4 validaciones, la imagen se subio al servidor y se creo la relacion entre el id de la pelicula recibido y la imagen subida"];
                        $status = 200;
                    } catch (\Throwable $th) {
                        $response = ["response" => "pasó 3 validaciones, falló en la cuarte (alg⌂n problema en el servidor)"];
                    }
                } else {
                    $response = ["response" => "pasó 2 validaciones, falló en la tercera (tipo de archivo invalido)"];
                }
            } else {
                $response = ["response" => "pasó 1 validacion, falló en la segunda (existe input 'imagen' pero esta vacio)"];
            }
        } else {
            $response = ["response" => "pasó 0 validaciones, falló en la primera (no se envio input 'imagen')"];
        }
        return $this->respond($response, $status);
    }

    // DELETE http://localhost:8080/api/pelicula/$id_pelicula/imagen/$id_imagen (v174)
    public function borrar_imagen($pelicula_id, $imagen_id) {
        $status = 400;
        $pelicula_imagen_model = new PeliculaImagenModel;
        $pelicula_imagen_model
            ->where("pelicula_id", $pelicula_id)
            ->where("imagen_id", $imagen_id)
            ->delete();
        if($pelicula_imagen_model->affectedRows()) {
            $imagen_model = new ImagenModel();
            $imagen = $imagen_model->find($imagen_id);
            $image_path = "../public/uploads/peliculas/$imagen->imagen";
            if($pelicula_imagen_model->where("imagen_id", $imagen_id)->countAllResults() == 0){
                try {
                    unlink("$image_path");
                    $imagen_model->delete($imagen_id);
                } catch (\Throwable $th) { 
                    // ...
                }
            }
            $response = ["response" => "Se ha eliminado la relacion entre la película $pelicula_id y la imagen $imagen_id."];
            $status = 200;
        } else {
            $response = ["response" => "La relacion entre la película $pelicula_id y la imagen $imagen_id no existe."];
        }
        return $this->respond($response, $status);
    }
}