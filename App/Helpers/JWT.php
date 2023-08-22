<?php
namespace App\Helpers;

class JWT
{
    // recibe la informacion a docodificar intercambiando + / remplazan a - _
    // respectivamente y se eliminan los caracteres =
    public function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    // Genera un jwt con los datos que recibe de la peticion
    public function generate_jwt($headers, $payload, $secret = 'R_051')
    {
        // Codificar la cabecera en base64 usando el metodo creado
        $headers_encoded = $this->base64url_encode(json_encode($headers));
        // Codificar el payload en base64 usando el metodo creado
        $payload_encoded = $this->base64url_encode(json_encode($payload));
        // Crea una firma HMAC-SHA256
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
        // Codificar la firma creada en base64url
        $signature_encoded = $this->base64url_encode($signature);
        // Combinr todos los componentes en un JWT
        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
        // regresar el JWT
        return $jwt;
    }

    public function validate_jwt($jwt, $secret = 'R_051')
    {

        // split the jwt
        $tokenParts = explode('.', $jwt);
        // Decodificar la primara parte del token
        $header = base64_decode($tokenParts[0]);
        // Decodificar la segunda parte del token
        $payload = base64_decode($tokenParts[1]);
        // Decodificar la tercera parte del token
        $signature = $tokenParts[2];

        // Verificar si el tiempo del token a expirado
        $expiration = json_decode($payload)->exp;
        $is_token_expired = ($expiration - time()) > 0;
        // Creando una firma basada en la cabecera y el payload usando la llave (secret)
        // Codificando cabecera
        $header_encode = $this->base64url_encode($header);
        // Codificando payload
        $payload_encode = $this->base64url_encode($payload);
        // Creando la firma
        $signature_build = hash_hmac('SHA256', "$header_encode.$payload_encode", $secret, true);
        // Codificando la firma
        $signature_encode = $this->base64url_encode($signature_build);
        // verificar si la firma recibida en igual a la firma creada
        $is_signature_valid = ($signature_encode === $signature);
        // Retornamos verdadero o falso dependiendo si el token a expirado y la firma es valida
        return ($is_token_expired && $is_signature_valid);
    }

    public function get_auth_header()
    {
        $header = null;

        if (isset($_SERVER['Authorization'])) {
            $header = trim($_SERVER['Authorization']);
        } else if (isset($_SERVER['HTTP_Authorization'])) {
            $header = trim($_SERVER['HTTP_Authorization']);
        } else if (function_exists('apache_request_headers')) {
            $requestHeader = apache_request_headers();
            $requestHeader = array_combine(array_map('ucwords', array_keys($requestHeader)), array_values($requestHeader));
            if (isset($requestHeader['Authorization'])) {
                $header = trim($requestHeader['Authorization']);
            }
        }
        return $header;

    }

    public function get_bearer_token()
    {
        $header = $this->get_auth_header();

        // Obtener el token de la cabecera
        if (!empty($header) && preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
?>