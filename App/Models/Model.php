<?php
/**
 * Clase padre para todas las demas clases model, aqui estara
 * la coneccion con la base de datos.
 */
namespace App\Models;

use PDO;
use PDOException;

class Model
{
    private $db_name;
    private $db_user;
    private $db_pass;
    protected $pdo;
    /**
     * Metodo para conectarse a la base de datos.
     * @return void
     */
    public function __construct()
    {
        $envVars = parse_ini_file("../.env");
        $this->db_name = $envVars['DB_NAME'];
        $this->db_user = $envVars['DB_USER'];
        $this->db_pass = $envVars['DB_PASS'];
    }
    public function connect()
    {
        try {
            # Se crea un objeto PDO (PHP Data Objects) para manejar la conexion con la base de datos.
            $this->pdo = new PDO("pgsql:dbname=$this->db_name", $this->db_user, $this->db_pass);
            # Se establecen los atributos ATTR_ERRMODE para controlar como se manejaran los errores que puedan ocurrir durante la conexion
            # Y el atributo ERRMODE_EXCEPTION indica que los errores se manejaran lanzando excepciones
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Metodo para cerrar la conexion con la base de datos.
     * @return void
     */
    public function close()
    {
        // Se cierra la conexion con la base de datos
        $this->pdo = null;

    }

    /**
     * Funcion que recibe el correo y contrasena del usuario para
     * loguearse.
     * @param mixed $email
     * @param mixed $password
     * @return mixed
     */
    public function login($email, $password)
    {
        try {
            $this->connect();
            // Se prepara la consulta sql
            $sql = "SELECT id, correo FROM usuarios WHERE correo = :correo AND contrasena = :contrasena";
            // Se prepara la sentencia sql
            $stmt = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            // Se pasan los parametros
            $stmt->bindParam(":correo", $email);
            $stmt->bindParam(":contrasena", $password);
            // Se ejecuta la sentencia sql
            $stmt->execute();
            // Se almacena el resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // Se cierra la conexion con la base de datos
            $this->close();
            // Se retorna el resultado
            return $result;
        } catch (PDOException $exeption) {
            echo "Error: " . $exeption->getMessage();
        }
    }
}