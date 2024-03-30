<?php

namespace App\Controllers\Dashboard;

use App\Models\PeliculaModel;
use App\Controllers\BaseController;

class Pelicula extends BaseController
{
    // list all resources
    public function index(): string
    {

        session()->set("ip", "192.155.14.187");
        session()->set("ip2", "248.074.133.05");

        session()->set("session_key", [
            "origin" => "Dashboard/Pelicula::index",
            "owner" => "lionel prats",
            "shadow_pass" => "1sadas4d4d5as4asd245",
        ]);

        $peliculaModel = new PeliculaModel();
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
        $peliculaModel = new PeliculaModel();
    
        $data = [
            'titulo' => $this->request->getPost("titulo"),
            'descripcion' => $this->request->getPost("descripcion"),
        ];
        
        $result = $peliculaModel->update($id, $data);
        
        if($result) {
            // return redirect()->back();
            return redirect()->to("/dashboard/pelicula")->with("mensaje", "Película editada exitosamente");;
            // return redirect()->route("pelicula.test");
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