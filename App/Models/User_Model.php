<?php
/**
 * Clase para el modelo del user, en esta clase existira la logica que maneje
 * las peticiones con la base de datos.
 */
namespace App\Models;

class User_Model extends Model
{
    /**
     * Metodo para consultar el correos y contrasena en la base de datos.
     * Sirve para el login
     * @param mixed $user
     * @param mixed $pass
     * @return array
     */
    public function consult_user($user, $pass)
    {
        // Se almacena el resultado de la consulta en una variable
        $result = $this->login($user, $pass);
        // Se retorna el resultado de la consulta
        return $result;
    }
}