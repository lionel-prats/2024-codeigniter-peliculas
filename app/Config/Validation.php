<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];
    // /vendor/codeigniter4/framework/system/Validation/Views/list.php
    // /vendor/codeigniter4/framework/system/Validation/Views/single.php

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $categorias = [
        "titulo" => "required|min_length[3]|max_length[255]"
    ];
    public $etiquetas = [
        "titulo" => "required|min_length[3]|max_length[255]",
        "categoria_id" => "required|is_natural",
    ];
    public $imagenes = [
        "uploaded[imagen]",
        "mime_in[imagen,image/jpg,image/gif,image/png,image/jpeg]",
        "max_size[imagen,4096]",
    ];
    public $peliculas = [
        "titulo" => "required|min_length[3]|max_length[255]",
        "descripcion" => "required|min_length[3]|max_length[2000]",
        "categoria_id" => "required|is_natural",
    ];
    public $login_usuarios = [
        "email" => "required|min_length[3]|max_length[70]",
        "contrasena" => "required|min_length[5]|max_length[15]",
    ];
    public $registro_usuarios = [
        "usuario" => "required|min_length[3]|max_length[20]|is_unique[usuarios.usuario]",
        // is_unique[usuarios.usario] va a la base de datos y verifica que no exista previamente el dato que se quiere insertar en el campo usuario de la tabla usuarios (v88)
        
        "email" => "required|min_length[3]|max_length[70]|is_unique[usuarios.email]",
        // is_unique[usuarios.email] va a la base de datos y verifica que no exista previamente el dato que se quiere insertar en el campo email de la tabla usuarios (v88)
        
        "contrasena" => "required|min_length[5]|max_length[15]",
    ];

}
