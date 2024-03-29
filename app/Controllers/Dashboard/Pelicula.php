<?php

namespace App\Controllers\Dashboard;

use App\Models\PeliculaModel;
use App\Controllers\BaseController;

class Pelicula extends BaseController
{
    // list all resources
    public function index(): string
    {
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
            // echo "La película '" . $this->request->getPost("titulo") . "' se ha creado correctamente con el id $newId.";
            return redirect()->to("/dashboard/pelicula");
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
            return redirect()->to("/dashboard/pelicula");
            // return redirect()->route("pelicula.test");
        }

    }   
    
    // delete a resource
    public function delete($id)//: string
    {   
        $peliculaModel = new PeliculaModel();    
        $result = $peliculaModel->delete($id);
        if($result) {
            return redirect()->back();
        }
    }   
    
    // controller for proofs
    public function test($arg1, $arg2)//: string
    {   
        echo "Argumento $arg1 recibido correctamente<br>";
        echo "Argumento $arg2 recibido correctamente<br>";
        echo "<br><a href='/dashboard/pelicula'>Get Back</a>";
    }   
}