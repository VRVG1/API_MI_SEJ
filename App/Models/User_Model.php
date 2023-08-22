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

    /**
     * Agrega un usuario con los datos proporcionados a la base de datos.
     * @param mixed $data
     * @return bool
     */
    public function post_user($data)
    {
        try {
            // creamos la coneccion a la base de datos
            $this->connect();
            // Preparamos la consulta
            $query = $this->pdo->prepare('INSERT INTO usuarios (correo, contrasena, rol, nombre) VALUES (:correo, :contrasena, :rol, :nombre)');
            // Se pasan los parametros
            $query->bindParam(':correo', $data['correo']);
            $query->bindParam(':contrasena', $data['contrasena']);
            $query->bindParam(':rol', $data['rol']);
            $query->bindParam(':nombre', $data['nombre']);
            // Ejecutamos la consulta
            $query->execute();
            // Cerramos la coneccion
            $this->close();
            // Retornamos el resultado de la consulta
            return true;
        } catch (\PDOException $e) {
            // Si ocurre un error lo mostramos
            return false;
        }
    }

    /**
     * Metodo que realiza una consulta general de los usuarios de la base de datos.
     * pero no regresamos el password.
     * @return mixed
     */
    public function get_all_users()
    {
        try {
            // creamos la coneccion a la base de datos
            $this->connect();
            // Preparamos la consulta
            $query = $this->pdo->prepare('SELECT id, correo, rol, nombre FROM usuarios');
            // Ejecutamos la consulta
            $query->execute();
            // Cerramos la coneccion
            $this->close();
            // Retornamos el resultado de la consulta
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            // Comprobamos si hay resultados
            if ($result) {
                return $result;
            }
            return false;
        } catch (\PDOException $e) {
            // Cerramos la coneccion
            $this->close();
            return false;
        }
    }

    /**
     * Se consultan un usuario en especifico de la base de datos.
     * retornamos el resultado o false si no hay resultado.
     * @param mixed $id
     * @return mixed
     */
    public function get_one_user($id)
    {
        try {
            // creamos la coneccion a la base de datos
            $this->connect();
            // Preparamos la consulta
            $query = $this->pdo->prepare('SELECT id, correo, rol, nombre  FROM usuarios WHERE id = :id');
            // Se pasan los parametros
            $query->bindParam(':id', $id);
            // Ejecutamos la consulta
            $query->execute();
            // Cerramos la coneccion
            $this->close();
            // Retornamos el resultado de la consulta
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            // Comprobamos si hay resultados
            if ($result) {
                return $result;
            }
            // Si no hay resultados regresamos false.
            return false;
        } catch (\PDOException $e) {
            // Cerramos la coneccion
            $this->close();
            return false;
        }
    }

    public function update_user($id, $data)
    {
        try {
            // Creamos coneccion a la base de datos
            $this->connect();
            // Comprobamos si la contrasena es la misma que la anterior
            // Prepara la consulta
            $query = $this->pdo->prepare('SELECT contrasena FROM usuarios WHERE id = :id');
            // Se pasan los parametros
            $query->bindParam(':id', $id);
            // Ejecuta la consulta
            $query->execute();
            // Obtenemos los resultado
            $old_pass = $query->fetch(\PDO::FETCH_ASSOC);
            // Comprobamos si las dos contrasenas no son iguales
            if (!$this->compare_pass($old_pass['contrasena'], $data['contrasena_anterior'])) {
                // Mandamos mensaje de error
                return "error";
            }
            // en caso de que las contrasenas coincidan
            // Prepara la consulta
            $query = $this->pdo->prepare('UPDATE usuarios SET correo = :correo, contrasena = :contrasena, rol = :rol, nombre = :nombre WHERE id = :id');
            // Se pasan los parametros
            $query->bindParam(':correo', $data['correo']);
            $query->bindParam(':contrasena', $data['contrasena']);
            $query->bindParam(':rol', $data['rol']);
            $query->bindParam(':nombre', $data['nombre']);
            $query->bindParam(':id', $id);
            // Ejecuta la consulta
            $query->execute();
            // Cerramos la coneccion
            $this->close();
            // Retornamos el resultado de la consulta
            return true;
        } catch (\PDOException $e) {
            // Cerramos la coneccion
            $this->close();
            return false;
        }
    }

    public function delete_one_user($id)
    {
        try {
            // Se verifica si existe el id
            $verify = $this->get_one_user($id);
            if (!$verify) {
                return false;
            }
            // Creamos coneccion a la base de datos
            $this->connect();
            // Prepara la consulta
            $query = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
            // Se pasan los parametros
            $query->bindParam(':id', $id);
            // Ejecuta la consulta
            $query->execute();
            // Cerramos la coneccion
            $this->close();
            // Retornamos el resultado de la consulta
            return true;
        } catch (\PDOException $e) {
            // Cerramos la coneccion
            $this->close();
            return false;
        }
    }

    /**
     * Compara la contrasena que se envia con la contrasena de la base de datos.
     * @param mixed $old_pass
     * @param mixed $compare_pass
     * @return bool
     */
    private function compare_pass($old_pass, $compare_pass)
    {
        return password_verify($compare_pass, $old_pass);
    }
}