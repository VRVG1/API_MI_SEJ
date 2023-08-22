<?php
/**
 * Clase para controlar las acciones que tengan que ver con el usuario.
 */
namespace App\Controllers;

use App\Helpers\JWT;
use App\Models\User_Model;

class User_Controller
{
    public function index()
    {
    }

    public function login()
    {
        // Obtenemos los datos de la peticion post.
        $data = json_decode(file_get_contents("php://input"));
        // Obtenemos los datos del usuario.
        $user = $data->user;
        // Obtenemos la contraseña del usuario.
        $pass = $data->pass;
        // Instanciamos el modelo de usuario.
        $user_model = new User_Model();
        // Realizamos la consulta al modelo.
        $result = $user_model->consult_user($user, $pass);
        // Si no hay resultados.
        if (!$result) {
            // Agregamos un mensaje de error.
            $result['message'] = 'Acceso denegado';
            $result['status'] = 401;
            // Retornamos el resultado.
            return $result;
        }
        // Agregamos un mensaje de confirmacion.
        $result['message'] = 'Acceso autorizado';
        // Agregamos el token JWT.
        $result_with_jwt = $this->add_jwt($result);
        // Retornamos el resultado.
        return $result_with_jwt;
    }

    private function add_jwt($payload)
    {
        // Crear la cabecera para el JWT
        $header = array('alg' => 'HS256', 'typ' => 'JWT');
        // Se le agrega al payload el tiempo de expiracion.
        $payload['exp'] = time() + 3600;
        // Se crea el JWT
        $jwtObjet = new JWT;
        $jwt = $jwtObjet->generate_jwt($header, $payload);
        // Se agrega al payload el JWT.
        $payload['Token'] = $jwt;
        // Retornamos el JWT.
        return $payload;

    }
}