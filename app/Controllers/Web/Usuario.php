<?php

namespace App\Controllers\Web;

use App\Models\UsuarioModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Usuario extends BaseController
{
    // proof method
    public function crear_usuario()
    {
        $usuarioModel = new UsuarioModel();

        $data = [
            'usuario' => "regular",
            'email' => "regular@gmail.com",
            'contrasena' => $usuarioModel->contrasenaHash("12345"),
        ];
        $result = $usuarioModel->insert($data, true); 
        return $result;
    }
    // proof method
    public function verificar_contrasena()
    {
        $usuarioModel = new UsuarioModel();
        dd(
            $usuarioModel->contrasenaVerificar("12345", '$2y$10$nNLE7AvL54j9VEycSTD/UemWQPeanJIE.21TrHfnUq3xQnbBC5COW'),
            $usuarioModel->contrasenaVerificar("12345", '$2y$10$hNtPDZTVSTVMbaLXvlQS7eVIpNiq4di.txnO/p4s61Jtyi0T13PhC'),
        );
    }
    // render user login form
    public function login()//: string
    {
        // $usuarioModel = new UsuarioModel();
        // $usuario = $usuarioModel->select("id, usuario, email, contrasena, tipo")
        //                         -> where("email", "admin")
        //                         -> orwhere("usuario", "admin")
        //                         ->first();    
        // // traduccion de la consulta anterior a lenguaje SQL
        // $sql_query_anterior = $usuarioModel->db->getLastQuery();
        // echo $sql_query_anterior;
        // echo "<pre>";
        // print_r($usuario);
        // echo "</pre>";
        // exit;
        $data = [
            "tituloVista" => "Iniciar Sesión"
        ];
        echo view("web/usuario/login", $data);    
    }   
    // process user login form
    public function login_post()//: string
    {
        if($this->validate("login_usuarios")){
            $usuarioModel = new UsuarioModel();
            // echo "<pre>";
            // print_r($usuarioModel);
            // exit;

            $email = $this->request->getPost("email"); // el usuario va a poder ingresar con email o usuario
            $contrasena = $this->request->getPost("contrasena");

            $usuario = $usuarioModel->select("id, usuario, email, contrasena, tipo")
                                    -> where("email", $email)
                                    -> orwhere("usuario", $email)
                                    -> first();    
            // $sql_query_anterior = $usuarioModel->db->getLastQuery();
            // echo "$sql_query_anterior";
            // echo "\n\n";
            // print_r($usuario);
            // exit;       
            if(!$usuario) {
                // el dato ingresado no coincide ni con el campo email ni con el campo usuario
                return redirect()->back()->with("mensaje", "el dato ingresado en el input 'Email/Usuario' no coincide ni con el campo email ni con el campo usuario");
            }
            if( $usuarioModel->contrasenaVerificar($contrasena, $usuario->contrasena) ){
                // las credenciales son válidas

                // inicializo la sesion (creo una instancia de sesion)
                $session = session();
                
                // echo json_encode($usuario);
                // echo "\n";
                
                // elimino la contraseña hasheada del objeto usuario andes de guardar los datos en sesion 
                // unset elimina un elemento, tanto de un array como de un objeto
                unset($usuario->contrasena);
                
                // echo json_encode($usuario);
                // echo "\n";
                
                // convierto el objeto del usuario en array para setear cada dato del objeto como una variable de sesion
                // $session->set((array) $usuario);

                session()->set("usuario", $usuario);
                
                // echo json_encode(session("id"));
                // echo "\n";
                // echo json_encode($session->get("usuario"));
                // echo "\n";
                // echo json_encode(session("email"));
                // echo "\n";
                // echo json_encode($session->get("tipo"));
                // echo "\n";    
                // exit;
            
                $message = "Bienvenid@ <span class=\"fw-bold\">$usuario->usuario</span>";
                return redirect()->to("/dashboard/categoria")
                    ->with("mensaje", $message)
                    ->with("alert-bg", "alert-success");
            }
            // el password no coincide con el del usuario en la base de datos
            return redirect()->back()->with("mensaje", "el password no coincide con el del usuario en la base de datos");
        }
        session()->setFlashdata([
            "validation" => $this->validator->getErrors(),
        ]);
        return redirect()->back()->withInput();
    }   
    // render user register form
    public function register()//: string
    {
        // session()->destroy();
        $data = [
            "tituloVista" => "Regitrarse"
        ];
        echo view("web/usuario/register", $data);    
    }  
    // process user register form
    public function register_post()//: string
    {

        // ddl($this->validator, 2);

        if($this->validate("registro_usuarios")){
            $usuarioModel = new UsuarioModel();
            $data = [
                'usuario' => $this->request->getPost("usuario"),
                'email' => $this->request->getPost("email"),
                'contrasena' =>  $usuarioModel->contrasenaHash($this->request->getPost("contrasena")),
            ];
            $usuarioModel->save($data); 

            // return redirect()->to("/login")->with("mensaje", "Login exitoso");
            $message = "Bienvenid@ <span class=\"fw-bold\">" . $this->request->getPost("usuario"). "</span>! Por favor, inicia sesión para confirmar el registro.";
            return redirect()->to(route_to("usuario.login"))
                ->with("mensaje", $message)
                ->with("alert-bg", "alert-success");
        }
        // ddl($this->validator->listErrors());
        // ddl($this->validator->getErrors());
        // ddl($this->validator, 2);
        // echo $this->validator->listErrors();
        // exit; 

        // guardo la variable de session flash "validation" para notificar al usuario de los errores de validacion 
        // $this->validator->listErrors() carga el contenido de /vendor/codeigniter4/framework/system/Validation/Views/list.php 
        session()->setFlashdata([
            // "validation" => $this->validator->listErrors(),
            // "validation" => $this->validator,
            "validation" => $this->validator->getErrors(),
            "email" => $this->request->getPost("email"),
            "usuario" => $this->request->getPost("usuario"),
        ]);

        return redirect()->back()->withInput();
    }
    // logout user session
    public function logout()
    {
        session()->destroy();
        return redirect()->to((route_to("usuario.login")));
    }
}
