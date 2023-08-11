<?php
include "../db.php";
include "../jwt_utils.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el contenido del request
    $data = json_decode(file_get_contents("php://input", true));
    // Obteniendo las variables de entorno para la coneccion con la base de datos
    $envVariables = parse_ini_file('../.env');
    // Crear la coneccion con la base de datos
    $DB = new DBconection($envVariables['DB_NAME'], $envVariables['DB_USER'], $envVariables['DB_PASS']);
    //Conectarse a la base de datos
    $DB->conectar();
    // Buscar los datos que se reciben en el request en la base de datos
    // NOTA: Se deberia unificar el nombre de los atributos
    $result = $DB->getUsuario($data->correo, $data->contrasena);
    // verificar si result tienen datos, en caso de tener datos
    // se da acceso a la aplicacion, en caso contrario no se le da acceso.
    if (!empty($result)) {
        //Obetener el primer resultado del arreglo $result
        $datos = $result[0];
        //Quitar la contrasena del los datos del arreglo
        unset($datos["contrasena"]);
        // Se agrega el mensaje al contenido
        $datos["mensaje"] = "Acceso Autorizado";
        //Crear la cabecera para el jwt
        $header = array('alg' => 'HS256', 'typ' => 'JWT');
        // Se crea el payload, que son el contenido resultante 
        // mas el tiempo de vida del token.
        $payload = [...$datos, 'exp' => (time() + 60)];
        // crear jwt
        $jwt = generate_jwt($header, $payload);
        // Se agrega el jwt al contenido del response
        $payload = [...$payload, 'token' => $jwt];
        // Se convierte el arreglo a json
        $jsonResultado = json_encode($payload);
        // Se agrega el code response
        http_response_code(200);
        // Se agrega el header
        header("Content-type: application/json; charset=UTF-8");
        // Se retorna el resultado
        echo $jsonResultado;
    } else {
        // Se agrega el mensaje al contenido
        $jsonResultado = json_encode(array("mensaje" => "Acceso Denegado"));
        //Se agrega el code response
        http_response_code(401);
        // Se agrega el header
        header("Content-type: application/json; charset=UTF-8");
        // Se retorna el resultado
        echo $jsonResultado;
    }
}
?>