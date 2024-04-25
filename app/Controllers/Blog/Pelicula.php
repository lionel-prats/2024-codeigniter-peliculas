<?php 

namespace App\Controllers\Blog;

use App\Models\PeliculaModel;
use App\Controllers\BaseController;

class Pelicula extends BaseController{
    public function index()
    {
        $pelicula_model = new PeliculaModel();
        $db = \Config\Database::connect();
        $pelicula_model = $db->table("peliculas");

        $peliculas = $pelicula_model->select("peliculas.*, C.titulo as categoria")
            ->join("categorias C", "C.id = peliculas.categoria_id");
        if($buscar = $this->request->getGet("buscar")){
            $peliculas = $peliculas->like('peliculas.titulo', $buscar, 'both')
                ->orlike('peliculas.descripcion', $buscar, 'both');
        }    
        $peliculas = $peliculas->orderBy("peliculas.id")
            // ->paginate(10);
            ->getCompiledSelect();
        ddl($peliculas, 1);    
        // ddl($pelicula_model->getLastQuery()/* ->finalQueryString */);

        $data = [
            "titulo_vista" => "Listado Películas",
            "peliculas" => $peliculas,
            'pager' => $pelicula_model->pager,
        ];
        return view('blog/pelicula/index', $data);
    }
    public function show($id_pelicula)
    {
        $pelicula_model = new PeliculaModel();
        $pelicula = $pelicula_model->find($id_pelicula);
        $data = [
            "titulo_vista" => "Detalle Película",
            "pelicula" => $pelicula,
        ];
        return view('blog/pelicula/show', $data);
    }
}