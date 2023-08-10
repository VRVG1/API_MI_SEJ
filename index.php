<?php
include "db.php";
include "jwt_utils.php";
// $base_datos = new DBconection("tarea_trigger", "vrvg", "vrvg");

// $base_datos->conectar();
// $response = $base_datos->getUsuarios();
// echo $response;

$headers = array('alg' => 'HS256', 'typ' => 'JWT');
$payload = array('username' => "victor", 'exp' => (time() + 60));

$jwt = generate_jwt($headers, $payload);
$jwt_valid = validate_jwt($jwt . "a");
var_dump($jwt_valid);
?>
