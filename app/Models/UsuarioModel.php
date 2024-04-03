<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';

    // defino el formato de las consultas a la DB (std class) 
    // protected $returnType       = 'array';
    protected $returnType       = 'object';

    // defino los campos de la tabla que voy a manejar (a los que quiero acceder via consultas) desde el ORM
    protected $allowedFields    = ["usuario", "email", "contrasena"];

    /**
     * genera un hash para una contraseña dada.
     *
     * toma una contraseña en texto plano y devuelve su hash correspondiente
     *
     * @param string $contrasenaPlano la contraseña en texto plano
     * @return string el hash de la contraseña
    */
    function contrasenaHash($contrasenaPlano): string
    {
        // PASSWORD_DEFAULT -> "2y" -> constante de php -> algortimo de hash
        return password_hash($contrasenaPlano, PASSWORD_DEFAULT);
    }
    
    /**
     * comprueba si se corresponden una contraseña plana con un hash
     *
     * toma una contraseña en texto plano y un hash, y comprueba si se corresponden
     *
     * @param string $contrasenaPlano la contraseña plana a comparar
     * @param string $contrasenaHash el hash a comparrar
     * @return bool devuelve true si las contraseñas se corresponden, false en caso contrario
    */
    function contrasenaVerificar($contrasenaPlano, $contrasenaHash): bool
    {
        return password_verify($contrasenaPlano, $contrasenaHash);
    }
}
