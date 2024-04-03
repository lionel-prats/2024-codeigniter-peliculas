<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
// $routes->get('/peliculas', 'Pelicula::index');

$routes->group("dashboard", function($routes){

    // bloque para testear los metodos de hash de contraseña para la entidad usuario
    $routes->get('usuario/crear', 'Web\Usuario::crear_usuario');
    $routes->get('usuario/probar/contrasena', '\App\Controllers\Web\Usuario::verificar_contrasena');
    // fin bloque 
    
    $routes->presenter("pelicula", ["controller" => "Dashboard\Pelicula"]);
    $routes->presenter("categoria", ["controller" => "Dashboard\Categoria"/* , "except" => "show" */]);
    $routes->get("test/(:num)/(:num)", "Dashboard\Pelicula::test/$1/$2", ["as" => "pelicula.test"]);
    $routes->get("destroy-session", "Dashboard\Pelicula::destruir_session", ["as" => "pelicula.destruir-session"]);
});

$routes->group("api", function($routes){
    $routes->presenter("protocolo");
    // GET    | api/protocolo           /Controllers/Protocolo::index    
    // GET    | api/protocolo/new       /Controllers/Protocolo::new      
    // GET    | api/protocolo/(.*)/edit /Controllers/Protocolo::edit/$1  
    // GET    | api/protocolo/(.*)      /Controllers/Protocolo::show/$1  
    // POST   | api/protocolo           /Controllers/Protocolo::create   
    // PATCH  | api/protocolo/(.*)      /Controllers/Protocolo::update/$1
    // PUT    | api/protocolo/(.*)      /Controllers/Protocolo::update/$1
    // DELETE | api/protocolo/(.*)      /Controllers/Protocolo::delete/$1 
});

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