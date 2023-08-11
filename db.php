<?php
/**
 * Classe que proporciona una coneccion a una base de datos
 * de potgresSQL (Creo que solo funciona en localhost)
 */
class DBconection
{
   private $dbname;
   private $user;
   private $password;
   private $pdo;

   public function __construct($dbname, $user, $password)
   {
      $this->dbname = $dbname;
      $this->user = $user;
      $this->password = $password;
   }
   public function conectar()
   {
      try {
         # Se crea un objeto PDO (PHP Data Objects) para manejar la conexion con la base de datos.
         $this->pdo = new PDO("pgsql:dbname=$this->dbname", $this->user, $this->password);
         # Se establecen los atributos ATTR_ERRMODE para controlar como se manejaran los errores que puedan ocurrir durante la conexion
         # Y el atributo ERRMODE_EXCEPTION indica que los errores se manejaran lanzando excepciones
         $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $exception) {
         echo "ERROR: " . $exception->getMessage();
      }
   }

   public function desconectar()
   {
      $this->pdo = null;
      echo "Base de datos desconectada";
   }

   public function ejecutarConsultaArbitraria($consulta)
   {
      $resultado = $this->pdo->query($consulta);
      return $resultado->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getUsuario(string $correo, string $contrasena)
   {
      //Crear query
      $query = "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena'";
      # Se realiza una consulta general a la tabla usuarios
      $resultado = $this->pdo->query($query);
      # Se almacena el arreglo resultante en una variable
      $filas = $resultado->fetchAll(PDO::FETCH_ASSOC);
      # Se tranforma el arreglo a json y se retorna
      return $filas;
   }
}
?>
