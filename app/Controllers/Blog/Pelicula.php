<?php 

namespace App\Controllers\Blog;

use App\Models\PeliculaModel;
use App\Models\CategoriaModel;
use App\Models\EtiquetaModel;
use App\Controllers\BaseController;

class Pelicula extends BaseController{
    // http://localhost:8080/blog
    public function index()
    { 
        /* 
        -- consulta full en caso de que el usuario filtre por P.categoria_id, PE.etiqueta_id y (P.titulo OR P.descripcion) vvv 

        SELECT peliculas.*, C.titulo as categoria, GROUP_CONCAT(E.titulo) as etiquetas 
        FROM peliculas 
        INNER JOIN categorias C ON C.id = peliculas.categoria_id 
        LEFT JOIN pelicula_etiqueta PE ON PE.pelicula_id = peliculas.id 
        LEFT JOIN etiquetas E ON E.id = PE.etiqueta_id 
        WHERE peliculas.categoria_id = '7' 
        AND PE.etiqueta_id = '35' 
        AND (peliculas.titulo LIKE '%3%' ESCAPE '!' OR peliculas.descripcion LIKE '%3%' ESCAPE '!') 
        GROUP BY peliculas.id 
        ORDER BY peliculas.id 
        LIMIT 10
        */
        $categoria_model = new CategoriaModel;
        $pelicula_model = new PeliculaModel();
        $peliculas = 
            
            // SELECT previo hasta el v159
            // $pelicula_model->select("peliculas.*, C.titulo as categoria")

            // SELECT #1 v160 -> GROUP_CONCAT() -> ver explicacion en 3_notas-generales.txt, apartado v160 
            // $pelicula_model->select("peliculas.*, C.titulo as categoria, GROUP_CONCAT(E.titulo) as etiquetas")
            
            // SELECT #2 v160
            $pelicula_model->select("peliculas.*, C.titulo as categoria, GROUP_CONCAT(DISTINCT(E.titulo)) as etiquetas, MIN(I.imagen) as imagen")
            
            ->join("categorias C", "C.id = peliculas.categoria_id", "inner")

            ->join("pelicula_etiqueta PE", "PE.pelicula_id = peliculas.id", "left")
            ->join("etiquetas E", "E.id = PE.etiqueta_id", "left")
            
            ->join("pelicula_imagen PI", "PI.pelicula_id = peliculas.id", "left")
            ->join("imagenes I", "I.id = PI.imagen_id", "left");

        if($categoria_id = $this->request->getGet("categoria_id")){
            $etiqueta_model = new EtiquetaModel;
            $etiquetas = $etiqueta_model
                ->where("categoria_id", $categoria_id)
                ->orderBy("titulo")
                ->findAll();
            $peliculas = $peliculas->where('peliculas.categoria_id', $categoria_id);
        } else {
            $etiquetas = [];
        }
        if($etiqueta_id = $this->request->getGet("etiqueta_id")){
            $peliculas = $peliculas->where('PE.etiqueta_id', $etiqueta_id);
        }  
        /* 
        // bloque reemplazado por la funcion when() (v156)
        if($buscar = $this->request->getGet("buscar")){
            $peliculas = $peliculas
                ->groupStart()
                    ->like('peliculas.titulo', $buscar, 'both')
                    ->orlike('peliculas.descripcion', $buscar, 'both')
                ->groupEnd();
        }     
        */
        // bloque de reemplazo del bloque comentado arriba (funcion when() - v156)
        $condition = $this->request->getGet("buscar");
        $peliculas = $peliculas
            ->when($condition, static function ($query, $condition) {
                $query->groupStart()
                    ->like('peliculas.titulo', $condition, 'both')
                    ->orlike('peliculas.descripcion', $condition, 'both')
                ->groupEnd();
            });
        $peliculas = $peliculas
            ->groupBy("peliculas.id")
            // LEFT JOIN... GROUP BY peliculas.id ORDER BY...
            
            // ->groupBy(["peliculas.id", "E.titulo"]) 
            // LEFT JOIN... GROUP BY peliculas.id, E.titulo ORDER BY...
            
            ->orderBy("peliculas.id")
            ->paginate(10);
            
        get_sql_query($pelicula_model->getLastQuery());
        
        // convierto el string "etiquetas" de la consulta en un array para poder iterarlo en la vista (v160)
        foreach($peliculas as $pelicula){
            if($pelicula->etiquetas){
                $etiquetas_explode = explode(",", $pelicula->etiquetas);
                $pelicula->etiquetas = $etiquetas_explode;
            } else {
                $pelicula->etiquetas = [];
            }
        }

        $data = [
            "titulo_vista" => "Listado Películas",
            "categorias" => $categoria_model->orderBy("titulo")->findAll(),
            // "etiquetas" => $etiqueta_model->orderBy("titulo")->findAll(),
            "etiquetas" => $etiquetas,
            "peliculas" => $peliculas,
            "pager" => $pelicula_model->pager,
            "old_categoria_id" => $categoria_id ?? "",
            "old_etiqueta_id" => $etiqueta_id ?? "",
            "old_buscar" => $condition ?? "",
        ];
        return view("blog/pelicula/index", $data);
    }
    // http://localhost:8080/blog/etiquetas_por_categoria/$categoria_id (v155)
    public function etiquetas_por_categoria($categoria_id)
    {
        $etiqueta_model = new EtiquetaModel;
        $etiquetas = $etiqueta_model
            ->where("categoria_id", $categoria_id)
            ->orderBy("titulo")
            ->findAll();
            
        // return json_encode($etiquetas);
        echo json_encode($etiquetas);
        exit;
    }

    public function show($id_pelicula)
    {
        $pelicula_model = new PeliculaModel();
        $pelicula = $pelicula_model
            ->select("peliculas.*, C.titulo as categoria")
            ->join("categorias C", "C.id = peliculas.categoria_id", "inner")
            ->find($id_pelicula);
        $data = [
            "titulo_vista" => "Detalle Película",
            "pelicula" => $pelicula,
            "pelicula_imagenes" => $pelicula_model->getImagesById($id_pelicula),
            "pelicula_etiquetas" => $pelicula_model->getEtiquetasById($id_pelicula),
        ];
        return view('blog/pelicula/show', $data);
    }
}