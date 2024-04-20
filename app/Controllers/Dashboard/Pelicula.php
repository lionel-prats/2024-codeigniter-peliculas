<?php

namespace App\Controllers\Dashboard;

use Config\Database;
use App\Models\ImagenModel;
use App\Models\EtiquetaModel;
use App\Models\PeliculaModel;
use App\Models\CategoriaModel;
use App\Controllers\BaseController;
use App\Models\PeliculaImagenModel;
use App\Models\PeliculaEtiquetaModel;
use CodeIgniter\Exceptions\PageNotFoundException; // v122 (Acceder a la imagen mediante un controlador)

helper('globals'); 

class Pelicula extends BaseController
{
    // list all resources
    public function index(): string
    {
        // $contrasena_plana = "1234";
        // echo "$contrasena_plana<br>";
        // echo PASSWORD_DEFAULT . "<br>";
        // echo password_hash($contrasena_plana, "2y") . "<br>";
        // echo password_hash($contrasena_plana, PASSWORD_DEFAULT) . "<br>";
        // echo password_hash($contrasena_plana, "2y") . "<br>";
        // exit;

        // cargo variables de sesion
        session()->set("ip", "192.155.14.187");
        session()->set("ip2", "248.074.133.05");
        session()->set("profesional", "Lionel Prats");
        session()->set("holamundo");

        session()->set("session_key", [
            "origin" => "Dashboard/Pelicula::index",
            "owner" => "lionel prats",
            "shadow_pass" => "1sadas4d4d5as4asd245",
        ]);

        // imprimo variables de sesion por pantalla
        // echo session("ip") . "<br>";
        // echo session("ip2") . "<br>";
        // echo session("profesional") . "<hr>";
        // echo "<pre>";
        // print_r(session("session_key"));
        // echo "</pre>";
        // echo "<hr>";
        // echo "<pre>";
        // print_r(session());
        // exit;


        $peliculaModel = new PeliculaModel();

        /*
        lionel -> ejemplo interesante VIDEO 79 "Operaciones comunes"    
        // $db = Database::connect();
        // $builder = $db->table("peliculas");
        // return $builder->limit(10, 20)->getCompiledSelect();

        // $db = Database::connect();
        // $builder = $db->table("peliculas");
        // return $peliculaModel->limit(10, 20)->getCompiledSelect();
        
 
        $db = Database::connect();
        $builder = $db->table("peliculas");
        
        // $ejemplo1 = $peliculaModel->asObject()
        //     ->select("peliculas.*", "categorias.titulo as categoria")
        //     ->join("categorias*", "categorias.id = peliculas.categoria.id")
        //     ->where("categorias.id", 1)
        //     // ->find();
        //     ->getCompiledSelect();
        
        $ejemplo2 = $builder
            ->select("peliculas.*", "categorias.titulo as categoria")
            ->join("categorias*", "categorias.id = peliculas.categoria.id")
            ->where("categorias.id", 1)
            // ->find();
            ->getCompiledSelect();
        return $ejemplo2; // SELECT `peliculas`.* FROM `peliculas` JOIN `categorias*` ON `categorias`.`id` = `peliculas`.`categoria`.`id` WHERE `categorias`.`id` = 1 
        */
        
        $peliculas = $peliculaModel->findAll();
        $peliculas = $peliculaModel
                        // ->select("peliculas.id, peliculas.titulo, peliculas.descripcion, categorias.titulo as categoria")
                        ->select("peliculas.*, c.titulo as categoria")
                        ->join("categorias c", "c.id = peliculas.categoria_id")
                        ->orderBy("peliculas.id")
                        ->find();

        $data = [
            "tituloVista" => "Listado de películas",
            "peliculas" => $peliculas,
        ];
        return view('dashboard/pelicula/index', $data);
    }   

    // list a single resource
    public function show($id): string
    {
        $peliculaModel = new PeliculaModel();
        $pelicula = $peliculaModel->find($id);

        $pelicula_imagenes = $peliculaModel->getImagesById($id);
        // ddl($pelicula_imagenes);
        
        // $pelicula = $peliculaModel->asObject()->find($id);
        // dd(
        //     $peliculaModel,
        //     $pelicula, 
        //     $pelicula->id, 
        //     $pelicula->titulo, 
        //     $pelicula->descripcion
        // );

        // ddl($peliculaModel->getEtiquetasById($id));

        $data = [
            "tituloVista" => "Detalle Película",
            "pelicula" => $pelicula,
            "pelicula_imagenes" => $pelicula_imagenes,
            "etiquetas" => $peliculaModel->getEtiquetasById($id),
        ];
        return view('dashboard/pelicula/show', $data);
    }   

    // render form to create new resource
    public function new(): string
    {
        
        $categoriaModel = new CategoriaModel;

        // ddl($categoriaModel->find(), 1);


        $data = [
            "tituloVista" => "Crear Película",
            "op" => "Create",
            "pelicula" => [
                "titulo" => "",
                "descripcion" => "",
            ],
            "categorias" => $categoriaModel->find(),
        ];
        return view('dashboard/pelicula/new', $data);
    }   
    
    // process form to create new resource
    public function create()//: string
    {   
        // $this->validate("peliculas") es referencia a Validation::peliculas (/app/Config/Validation.php)
        if($this->validate("peliculas")){
            $peliculaModel = new PeliculaModel();
            $data = [
                'titulo' => $this->request->getPost("titulo"),
                'descripcion' => $this->request->getPost("descripcion"),
                'categoria_id' => $this->request->getPost("categoria_id"),
            ];
            $result = $peliculaModel->insert($data, false); 
            if($result) {
                $newId = $peliculaModel->getInsertID();
                return redirect()->to("/dashboard/pelicula")->with("mensaje", "Película creada exitosamente");
            } else {
                echo "error";
            }
        } else {
            $validation = new \stdClass();
            $validation->descripcion =  $this->validator->getError("descripcion");
            $validation->titulo =  $this->validator->getError("titulo");
            $validation->categoria_id =  $this->validator->getError("categoria_id");
            
            session()->setFlashdata([
                /* "validation" => [
                    "descripcion" => $this->validator->getError("descripcion"),
                    "titulo" => $this->validator->getError("titulo")
                ] */
                "validation" => $validation
            ]);
            return redirect()->back()->withInput();
        }
    }   

    // render form to edit a resource
    public function edit($id): string
    {
        $peliculaModel = new PeliculaModel();
        $categoriaModel = new CategoriaModel;
        $pelicula = $peliculaModel->find($id);
        $data = [
            "tituloVista" => "Editar Película",
            "op" => "Update",
            "pelicula" => $pelicula,
            "categorias" => $categoriaModel->find(),
        ];
        return view('dashboard/pelicula/edit', $data);
    } 

    // process form to update a resource
    public function update($id)//: string
    {   
        if($this->validate("peliculas")){
            $peliculaModel = new PeliculaModel();
            $data = [
                'titulo' => $this->request->getPost("titulo"),
                'descripcion' => $this->request->getPost("descripcion"),
                'categoria_id' => $this->request->getPost("categoria_id"),
            ];
            $result = $peliculaModel->update($id, $data);
            if($result) {
                $insertar_imagen = $this->asignar_imagen($id);
                $mensaje = "Película editada. $insertar_imagen";
                
                // return redirect()->back();
                return redirect()->to("/dashboard/pelicula")->with("mensaje", $mensaje);
                // return redirect()->route("pelicula.test");
            }
        } else {

            $validation = new \stdClass();
            $validation->descripcion =  $this->validator->getError("descripcion");
            $validation->titulo =  $this->validator->getError("titulo");
            $validation->categoria_id =  $this->validator->getError("categoria_id");

            session()->setFlashdata([
                // "validation" => [
                //     "descripcion" => $this->validator->getError("descripcion"),
                //     "titulo" => $this->validator->getError("titulo")
                // ]
                "validation" => $validation
            ]);
            return redirect()->back()->withInput();
        }
    }   
    
    // delete a resource
    public function delete($id)//: string
    {   
        $peliculaModel = new PeliculaModel();    
        $result = $peliculaModel->delete($id);
        if($result) {
            return redirect()->back()->with("mensaje", "Película borrada exitosamente");
        }
    }   
    
    // controller for proofs -> http://localhost:8080/dashboard/test/248/496
    public function test($arg1, $arg2)//: string
    {   

        $imagenModel = new ImagenModel(); 
        ddl($imagenModel->getPeliculasById(4)/* , 1 */);

        // dd($this->asignar_imagen() ,1);

        echo "Argumento $arg1 recibido correctamente<br>";
        echo "Argumento $arg2 recibido correctamente<br>";
        echo "<br><a href='/dashboard/pelicula'>Get Back</a>";
    } 
    
    public function destruir_session()
    {
        session()->destroy();
        session()->setFlashdata("mensaje", "Se ha destruído la sesión!!");
        return redirect()->back();
    }

    // v123 - metodo para borrar una imagen (tanto fisicamente en el server como de las tablas imagenes y pelicula_imagen)
    // POST /dashboard/pelicula123/imagen_delete/$imagen_id (v123) 
    public function borrar_imagen123($imagen_id) {
        $imagen_model = new ImagenModel();
        $pelicula_imagen_model = new PeliculaImagenModel();

        // valido que la imagen a borrar exista en la tabla imagenes
        $imagen = $imagen_model->find($imagen_id);
        if($imagen == null){
            return redirect()->back()->with("mensaje", "No existe imagen en BD");
        }

        // ruta relativa de la imagen en el server
        $image_path = "../public/uploads/peliculas/$imagen->imagen";
        // $image_path = "uploads/peliculas/$imagen->imagen";
        
        // valido que la imagen exista en el server
        if (!file_exists($image_path)) {
            return redirect()->back()->with("mensaje", "No existe imagen en server");
        }

        try {
            unlink($image_path);
            // borrado de registros asociados a la imagen en tabla spelicula_imagen
            $pelicula_imagen_model->where("imagen_id", $imagen_id)->delete();
            // borrado del registro asociado a la imagen en tabla imagenens
            $imagen_model->delete($imagen_id);
            return redirect()->back()->with("mensaje", "Imagen borrada exitosamente");
        } catch (\Throwable $th) {
            return redirect()->back()->with("mensaje", "Falló el borrado de la imagen en el servidor");
        }
    }

    // POST /dashboard/pelicula/imagen_descargar/$imagen_id (v125) 
    public function descargar_imagen($imagen_id) {
        $imagen_model = new ImagenModel();
        $imagen = $imagen_model->find($imagen_id);
        if($imagen == null){
            return redirect()->back()->with("mensaje", "No existe imagen en BD");
        }
        $image_path = "../public/uploads/peliculas/$imagen->imagen";
        return $this->response
            ->download($image_path, null)
            ->setFileName("Imagen_$imagen_id" . "." . $imagen->extension);
    }
    
    // v123 - este metodo borra la relacion entre una imagen y una pelicula (registros en "pelicula_imagen"). A su vez, luego de este borrado, verifica si la imagen sigue asociada a otras peliculas, y si fuera el caso, elimina el registro correspondiente en "imagenes" y el archivo fisico alojado en el server 
    // POST /dashboard/pelicula126/imagen_delete/$imagen_id (v126) 
    public function borrar_imagen126($pelicula_id, $imagen_id) {
        $imagen_model = new ImagenModel();
        $pelicula_model = new PeliculaModel();
        $imagen = $imagen_model->find($imagen_id);
        if($imagen == null){
            return redirect()->back()->with("mensaje", "No existe imagen en BD");
        }
        $pelicula = $pelicula_model->find($pelicula_id);
        if($pelicula == null){
            return redirect()->back()->with("mensaje", "No existe pelicula en BD");
        }
        $image_path = "../public/uploads/peliculas/$imagen->imagen";
        if (!file_exists($image_path)) {
            return redirect()->back()->with("mensaje", "No existe imagen en server");
        }
        $pelicula_imagen_model = new PeliculaImagenModel();
        $pelicula_imagen_model->where("imagen_id", $imagen_id)
            ->where("pelicula_id", $pelicula_id)
            ->delete();   
        if($pelicula_imagen_model->where("imagen_id", $imagen_id)->countAllResults() == 0){
            try {
                unlink("$image_path");
                $imagen_model->delete($imagen_id);
            } catch (\Throwable $th) {
                return redirect()->back()->with("mensaje", "Falló el borrado de la imagen en el servidor");
            }
        }
        return redirect()->back()->with("mensaje", "Imagen asociada a '" . $pelicula->titulo . "' borrada exitosamente");
    }

    private function asignar_imagen($pelicula_id) // v119
    {
        if($image_file = $this->request->getFile("imagen")){
            // ddl($image_file->getName(), 2); // nombre original del archivo cargado en el input:file (v121)
            if($image_file->isValid()){
                if($this->validate("imagenes")){
                    $imagen_nombre = $image_file->getRandomName();
                    // $extension = $image_file->getExtension();
                    $extension = $image_file->guessExtension();
                    try {
                        // $image_file->move(WRITEPATH . "uploads/peliculas", $imagen_nombre);
                        $image_file->move(/* WRITEPATH .  */"../public/uploads/peliculas", $imagen_nombre);

                        // insert en tabla imagenes
                        $imagenModel = new ImagenModel();
                        $data = [
                            'imagen' => $imagen_nombre,
                            'extension' => $extension,
                            'data' => "Pendiente",
                        ];
                        $imagen_id = $imagenModel->insert($data); 
                        
                        
                        // insert en tabla pelicula_imagen
                        $PeliculaImagenModel = new PeliculaImagenModel();
                        $data = [
                            'pelicula_id' => $pelicula_id,
                            'imagen_id' => $imagen_id,
                        ];
                        $PeliculaImagenModel->insert($data); 

                        return "Imagen subida correctamente";
                    } catch (\Throwable $th) {
                        return "Problemas en el servidor, no se pudo cargar la imagen";
                    }
                } else {
                    // return $this->validator->listErrors();
                    return "Archivo inválido";
                }
                // $validated = $this->validate([
                //     "uploaded[imagen]",
                //     "mime_in[imagen,image/jpg,image/gif,image/png,image/jpeg]",
                //     "max_size[imagen,4096]"
                // ]);
                // if($validated) {
                //     $imagen_nombre = $image_file->getRandomName();
                //     $image_file->move(WRITEPATH . "uploads/peliculas", $imagen_nombre);
                // } 
            } else {
                return "El usuario no ha cargado ninguna imagen";
            }
        } else {
            return "El usuario no ha cargado ninguna imagen";
        }
    }

    // v122 - 122. Acceder a la imagen mediante un controlador vvv
    // http://localhost:8080/image/1713320426_49ecd23ec5f3bb440e9a.jpg
    function image($image)
    {
        // abre el archivo en modo binario
        if(!$image) {
            $image = $this->request->getGet("image");
        }
        $name = WRITEPATH . "uploads/peliculas/$image";
        if(!file_exists($name)) {
            throw PageNotFoundException::forPageNotFound();
        }
        $fp = fopen($name, "rb");
        // envia las cabeceras correctas 
        header("Content-Type: image/png");
        header("Content-Length: " . filesize($name));
        // vuelca la imagen y detiene el script 
        fpassthru($fp);
        exit;
    }

    public function etiquetas($id)
    {
        $categoriaModel = new CategoriaModel;
        $etiquetaModel = new EtiquetaModel;
        $peliculaModel = new PeliculaModel;
        $etiquetas = [];
        $categoria_id = null;
        if($this->request->getGet("categoria_id")) { // (v111)
            $categoria_id = $this->request->getGet("categoria_id");
            $etiquetas = $etiquetaModel->where("categoria_id", $categoria_id)
                                    ->find();
        }
        $data = [
            "tituloVista" => "Película - Etiquetas",
            "pelicula" => $peliculaModel->find($id),
            "categorias" => $categoriaModel->find(),
            "categoria_id" => $categoria_id,
            "etiquetas" => $etiquetas,
        ];
        return view('dashboard/pelicula/etiquetas', $data);
    }
    
    public function etiquetas_post($pelicula_id)
    {   
        $pelicula_etiqueta_model = new PeliculaEtiquetaModel;
        $etiqueta_id = $this->request->getPost("etiqueta_id");

        if(!$etiqueta_id) {
            session()->setFlashdata("mensaje", "Debes seleccionar una etiqueta para la película"); 
        } else {                                 
                     
            // verifico si ya existe una etiqueta asignada a la pelicula
            $existe_tag = $pelicula_etiqueta_model->existTagForMovie($pelicula_id, $etiqueta_id);
            if(!$existe_tag) {
                $pelicula_etiqueta_model->save([
                    "pelicula_id" => $pelicula_id,
                    "etiqueta_id" => $etiqueta_id,
                ]); 
                session()->setFlashdata("mensaje", "Se ha creado una nueva etiqueta para la película $pelicula_id"); 
            } else {
                session()->setFlashdata("mensaje", "Ya existe la etiqueta seleccionada para la película $pelicula_id");
            }
        }
        return redirect()->back();
    }

    // /pelicula/(:num)/etiqueta/(:num)/delete
    public function etiqueta_delete($pelicula_id, $etiqueta_id)
    {   
        $pelicula_etiqueta_model = new PeliculaEtiquetaModel;   
        $result = $pelicula_etiqueta_model->where("pelicula_id", $pelicula_id)
            ->where("etiqueta_id", $etiqueta_id)
            ->delete();
        if($result) {
            // echo json_encode(["deleted" => true,"pelicula_id" => $pelicula_id,"etiqueta_id" => $etiqueta_id]);
            echo '{"mensaje":"eliminado"}';
        }
    }
}