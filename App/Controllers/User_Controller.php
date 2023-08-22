<?php
/**
 * Clase para controlar las acciones que tengan que ver con el usuario.
 */
namespace App\Controllers;

use App\Helpers\JWT;
use App\Models\User_Model;

class User_Controller
{

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
    /**
     * Metodo que crea una instancia de la clase User_Model.
     * Para poder agregar un usuario.
     * @return bool|string
     */
    public function post_user()
    {
        // Obtenemos los datos de la peticion post.
        $data = json_decode(file_get_contents("php://input"), true);
        // Codificamos la contrasena con hash.
        $data['contrasena'] = $this->encode_pass($data['contrasena']);
        // Instanciamos el modelo de usuario.
        $user_model = new User_Model();
        // Mandamos a llamar al metodo post_user del modelo user.
        $result = $user_model->post_user($data);
        // Comprobamos que el resultado sea true y mandamos mensaje de exito.
        if ($result) {
            return json_encode(array('message' => 'Usuario registrado con exito'));
        }
        // Retornamos mensaje de error.
        return json_encode(array('message' => 'Error al registrar el usuario'));
    }

    /**
     * Metodo para obtener todos los usuarios.
     * Se retorna el json con los resultados o un mensaje de error
     * @return array
     */
    public function get_users()
    {
        // Instanciamos el modelo de usuario.
        $user_model = new User_Model();
        // Mandamos a llamar al metodo get_user del modelo user.
        $result = $user_model->get_all_users();
        // Comprobamos que el resultado sea un arreglo con datos.
        if (is_array($result)) {
            // Retornamos el resultado.
            return $result;
        }
        // Retornamos mensaje de error.
        return array('message' => 'Error al obtener los usuarios');
    }

    public function get_user($id)
    {
        // Instanciamos el modelo de usuario.
        $user_model = new User_Model();
        // Mandamos a llamar al metodo get_user del modelo user.
        $result = $user_model->get_one_user($id);
        // Comprobamos que el resultado sea un arreglo con datos.
        if (is_array($result)) {
            // Retornamos el resultado.
            return $result;
        }
        // Retornamos mensaje de error.
        return array('message' => 'Error al obtener el usuario');
    }

    /**
     * Metodo que actualizar los datos de un usuario.
     * En este caso actualiza todo, si la contrasena anterior es igual
     * a la contrasena almacenada en la base de datos.
     * @param mixed $id
     * @return array<string>
     */
    public function update_user($id)
    {
        // Obtenemos los datos de la peticion post.
        $data = json_decode(file_get_contents("php://input"), true);
        // Encriptar la constrasena
        $data['contrasena'] = $this->encode_pass($data['contrasena']);
        // Instanciamos el modelo de usuario.
        $user_model = new User_Model();
        // Mandamos a llamar al metodo para actualizar un usuario
        $result = $user_model->update_user($id, $data);
        // Comprobamos si el resultado es true.
        if ($result === "error") {
            // Retornamos mensaje de error.
            return array('message' => 'Las contrasenas no coinciden');
        }
        if ($result) {
            // Retornamos el resultado.
            return array('message' => 'Usuario actualizado con exito');
        }
        // Retornamos mensaje de error.
        return array('message' => 'Error al actualizar el usuario');
    }

    public function delete_user($id)
    {
        // Instanciamos el modelo de usuario.
        $user_model = new User_Model();
        // Mandamos a llamar al metodo para actualizar un usuario
        $result = $user_model->delete_one_user($id);
        // Comprobamos si el resultado es true.
        if ($result) {
            // retornamos mensaje de exito.
            return array('message' => 'Usuario eliminado con exito');
        }
        // Retornamos mensaje de error.
        return array('message' => 'Error al eliminar el usuario');
    }

    /**
     * Metodo que codifica la contrasena con hash.
     * Usando el metodo por defecto de php.
     * @param mixed $pass
     * @return string
     */
    private function encode_pass($pass)
    {
        // Codificamos la contrasena con hash.
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    /**
     * Metodo que genera un JWT
     * @param mixed $payload
     * @return mixed
     */
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