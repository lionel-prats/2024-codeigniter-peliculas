<?php

namespace App\Controllers\Dashboard;

use App\Models\PeliculaModel;
use App\Controllers\BaseController;
use Config\Database;

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
        
        // $pelicula = $peliculaModel->asObject()->find($id);
        // dd(
        //     $peliculaModel,
        //     $pelicula, 
        //     $pelicula->id, 
        //     $pelicula->titulo, 
        //     $pelicula->descripcion
        // );

        

        $data = [
            "tituloVista" => "Detalle Película",
            "pelicula" => $pelicula,
        ];
        return view('dashboard/pelicula/show', $data);
    }   

    // render form to create new resource
    public function new(): string
    {
        $data = [
            "tituloVista" => "Crear Película",
            "op" => "Create",
            "pelicula" => [
                "titulo" => "",
                "descripcion" => "",
            ],
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
        $pelicula = $peliculaModel->find($id);
        $data = [
            "tituloVista" => "Editar Película",
            "op" => "Update",
            "pelicula" => $pelicula,
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
            ];
            $result = $peliculaModel->update($id, $data);
            if($result) {
                // return redirect()->back();
                return redirect()->to("/dashboard/pelicula")->with("mensaje", "Película editada exitosamente");
                // return redirect()->route("pelicula.test");
            }
        } else {

            $validation = new \stdClass();
            $validation->descripcion =  $this->validator->getError("descripcion");
            $validation->titulo =  $this->validator->getError("titulo");

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
    
    // controller for proofs
    public function test($arg1, $arg2)//: string
    {   
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

}