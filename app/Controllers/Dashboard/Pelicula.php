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

                $this->asignar_imagen($id);




                // return redirect()->back();
                return redirect()->to("/dashboard/pelicula")->with("mensaje", "Película editada exitosamente");
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

    private function asignar_imagen($pelicula_id) // v119
    {
        if($image_file = $this->request->getFile("imagen")){
            // ddl($image_file, 1);
            if($image_file->isValid()){
                $validated = $this->validate([
                    "uploaded[imagen]",
                    "mime_in[imagen,image/jpg,image/gif,image/png,image/jpeg]",
                    "max_size[imagen,4096]"
                ]);
                if($validated) {
                    $imagen_nombre = $image_file->getRandomName();
                    $image_file->move(WRITEPATH . "uploads/peliculas", $imagen_nombre);
                }
                return $this->validator->listErrors();
            }
        }
    }

    // este metodo, al ser privado, solo puede ser accedido dentro de esta clase (v107)
    private function generar_imagen()
    {
        $imagenModel = new ImagenModel();
        $data = [
            'imagen' => date("Y-m-d H:m:s"), // string(19) "2024-04-09 21:04:11"
            'extension' => "Pendiente",
            'data' => "Pendiente",
        ];
        return $imagenModel->insert($data, false); 
    }
    
    private function asignar_imagen2() // v107
    {
        $PeliculaImagenModel = new PeliculaImagenModel();
        $data = [
            'pelicula_id' => 44,
            'imagen_id' => 4,
        ];
        return $PeliculaImagenModel->insert($data, true); 
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