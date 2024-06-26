<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
// $routes->get('/peliculas', 'Pelicula::index');

$routes->group("api", ["namespace" => "App\Controllers\Api"], function($routes){
    
    $routes->get("pelicula/paginado", "Pelicula::paginado"); // v165
    $routes->get("pelicula/paginado_full", "Pelicula::paginado_full"); // v166
    $routes->get("pelicula/index_categoria_id/(:num)", "Pelicula::index_categoria_id/$1"); // v167
    $routes->get("pelicula/index_etiqueta_id/(:num)", "Pelicula::index_etiqueta_id/$1"); // v168
    $routes->post("pelicula/(:num)/etiquetas", "Pelicula::etiquetas_post/$1"); // v171
    $routes->delete("pelicula/(:num)/etiqueta/(:num)/delete", "Pelicula::etiqueta_delete/$1/$2");
    $routes->post("pelicula/(:num)/imagen/upload", "Pelicula::upload/$1"); // v173
    $routes->delete("pelicula/(:num)/imagen/(:num)", "Pelicula::borrar_imagen/$1/$2"); // v174

    $routes->resource("pelicula");
    // GET    | api/pelicula           \App\Controllers\Api\Pelicula::index       
    // GET    | api/pelicula/new       \App\Controllers\Api\Pelicula::new      
    // GET    | api/pelicula/(.*)/edit \App\Controllers\Api\Pelicula::edit/$1  
    // GET    | api/pelicula/(.*)      \App\Controllers\Api\Pelicula::show/$1  
    // POST   | api/pelicula           \App\Controllers\Api\Pelicula::create   
    // PATCH  | api/pelicula/(.*)      \App\Controllers\Api\Pelicula::update/$1
    // PUT    | api/pelicula/(.*)      \App\Controllers\Api\Pelicula::update/$1
    // DELETE | api/pelicula/(.*)      \App\Controllers\Api\Pelicula::delete/$1
     
    $routes->resource("categoria"); // controller -> \App\Controllers\Api\Categoria 
    $routes->resource("etiqueta"); // controller -> \App\Controllers\Api\Etiqueta (v172)
});

// /dashboard/pelicula
$routes->group("dashboard", function($routes){

    // bloque para testear los metodos de hash de contraseña para la entidad usuario
    $routes->get('usuario/crear', 'Web\Usuario::crear_usuario');
    $routes->get('usuario/probar/contrasena', '\App\Controllers\Web\Usuario::verificar_contrasena');
    // fin bloque 
    
    // /dashboard/pelicula/etiquetas/$id_pelicula
    $routes->get("pelicula/(:num)/etiquetas", "Dashboard\Pelicula::etiquetas/$1", ["as" => "pelicula.etiquetas"]);
    $routes->post("pelicula/(:num)/etiquetas", "Dashboard\Pelicula::etiquetas_post/$1", ["as" => "pelicula.etiquetas"]);
    $routes->post("pelicula/(:num)/etiqueta/(:num)/delete", "Dashboard\Pelicula::etiqueta_delete/$1/$2", ["as" => "pelicula.etiqueta_delete"]);
    
    // borrar imagen (v123)
    $routes->post("pelicula123/imagen_delete/(:num)", "Dashboard\Pelicula::borrar_imagen123/$1", ["as" => "pelicula.borrar_imagen123"]);
    
    // descargar imagen (v125)
    $routes->post("pelicula/imagen_descargar/(:num)", "Dashboard\Pelicula::descargar_imagen/$1", ["as" => "pelicula.descargar_imagen"]);

     // borrar imagen (v126)
     $routes->post("pelicula126/imagen_delete/(:num)/(:num)", "Dashboard\Pelicula::borrar_imagen126/$1/$2", ["as" => "pelicula.borrar_imagen126"]);

    $routes->presenter("categoria", ["controller" => "Dashboard\Categoria"/* , "except" => "show" */]);
    $routes->presenter("etiqueta", ["controller" => "Dashboard\Etiqueta"]);
    $routes->presenter("pelicula", ["controller" => "Dashboard\Pelicula"]);
    
    $routes->get("test/(:num)/(:num)", "Dashboard\Pelicula::test/$1/$2", ["as" => "pelicula.test"]);
    $routes->get("destroy-session", "Dashboard\Pelicula::destruir_session", ["as" => "pelicula.destruir-session"]);
});

// $routes->group("blog", function($routes){
    $routes->get("blog/etiquetas_por_categoria/(:num)", "Blog\Pelicula::etiquetas_por_categoria/$1", ["as" => "blog.pelicula.etiquetas_por_categoria"]);
    
    // v161
    $routes->get("blog/etiquetas/(:num)", "Blog\Pelicula::index_por_etiqueta/$1", ["as" => "blog.pelicula.index_por_etiqueta"]);
    
    // v162
    $routes->get("blog/categorias/(:num)", "Blog\Pelicula::index_por_categoria/$1", ["as" => "blog.pelicula.index_por_categoria"]);
    
    
    $routes->presenter("blog", ["controller" => "Blog\Pelicula"], ["only" => ["index", "show"]]);
// });

// $routes->group("api", function($routes){
//     $routes->presenter("protocolo");
//     // GET    | api/protocolo           /Controllers/Protocolo::index    
//     // GET    | api/protocolo/new       /Controllers/Protocolo::new      
//     // GET    | api/protocolo/(.*)/edit /Controllers/Protocolo::edit/$1  
//     // GET    | api/protocolo/(.*)      /Controllers/Protocolo::show/$1  
//     // POST   | api/protocolo           /Controllers/Protocolo::create   
//     // PATCH  | api/protocolo/(.*)      /Controllers/Protocolo::update/$1
//     // PUT    | api/protocolo/(.*)      /Controllers/Protocolo::update/$1
//     // DELETE | api/protocolo/(.*)      /Controllers/Protocolo::delete/$1 
// });

$routes->presenter("testing", ["only" => ["edit", "show"]]);
// GET testing/show/(.*)    /App/Controllers/Testing::show/$1
// GET testing/edit/(.*)    /App/Controllers/Testing::edit/$1
// GET testing/(.*)         /App/Controllers/Testing::show/$1

$routes->presenter("testing2", ["except" => ["edit", "show", "create", "update", "delete"]]);
// GET /testing2                /App/Controllers/Testing2::index
// GET /testing2/new            /App/Controllers/Testing2::new
// GET /testing2/remove/(.*)    /App/Controllers/Testing2::remove/$1

// $routes->presenter("testing3");
// GET    /Testing3             /App/Controllers/Testing3::index     
// GET    /Testing3/show/(.*)   /App/Controllers/Testing3::show/$1   
// GET    /Testing3/new         /App/Controllers/Testing3::new       
// GET    /Testing3/edit/(.*)   /App/Controllers/Testing3::edit/$1   
// GET    /Testing3/remove/(.*) /App/Controllers/Testing3::remove/$1 
// GET    /Testing3/(.*)        /App/Controllers/Testing3::show/$1   
// POST   /Testing3/create      /App/Controllers/Testing3::create    
// POST   /Testing3/update/(.*) /App/Controllers/Testing3::update/$1 
// POST   /Testing3/delete/(.*) /App/Controllers/Testing3::delete/$1 
// POST   /Testing3             /App/Controllers/Recurso_web::create    

// $routes->get('/login', 'Web\Usuario::login', ["as" => "usuario.login"]);
$routes->get('login', 'Web\Usuario::login', ["as" => "usuario.login"]);
// $routes->get('login', '\App\Controllers\Web\Usuario::login', ["as" => "usuario.login"]);

// $routes->post('/login', 'Web\Usuario::login_post', ["as" => "usuario.login_post"]);
$routes->post('login', 'Web\Usuario::login_post', ["as" => "usuario.login_post"]);
// $routes->post('login_post', '\App\Controllers\Web\Usuario::login_post', ["as" => "usuario.login_post"]);

$routes->get('register', 'Web\Usuario::register', ["as" => "usuario.register"]);
$routes->post('register', 'Web\Usuario::register_post', ["as" => "usuario.register_post"]);
$routes->post('logout', 'Web\Usuario::logout', ["as" => "usuario.logout"]);

// test (v122)
$routes->get("image/(:any)", "Dashboard\Pelicula::image/$1", ["as" => "get_image"]);
// http://localhost:8080/image/1713320426_49ecd23ec5f3bb440e9a.jpg

$routes->get("blog", "Dashboard\Pelicula::image/$1", ["as" => "get_image"]);