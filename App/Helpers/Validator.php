<?php
namespace App\Helpers;

/**
 * Clase para validar el tipo de imagen asi como el tamano de la imagen
 */
class Validator
{
    private $image;
    // Para calcular los bytes deaseados usamos la siguiente formula
    //  multiplicas el valor de los MB por 2^20
    // Ejemplo 20 MB = 20 * 2^20 = 20971520
    private $max_size = 20971520;
    /**
     * Constructor que recibe la imagen
     * @param mixed $image
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Metodo para validar la imagen, regresa un 
     * arreglo vacio si todo esta bien.
     * @return array<string>
     */
    public function validate_image()
    {
        // Comprobamos si la imagen se subio correctamente
        if ($this->image['error'] !== UPLOAD_ERR_OK) {
            return ['message' => 'Error al cargar la imagen'];
        }
        // Comprobamos si la imagen no sobrepasa el tamano maximo
        if ($this->image['size'] > $this->max_size) {
            return ['message' => 'La imagen es muy grande'];
        }
        // Definimos los tipos de imagen permitidas
        $image_types = ['jpeg', 'png', 'jpg'];
        // Obtenemos el tipo de imagen
        $image_type = pathinfo($this->image['name'], PATHINFO_EXTENSION);
        // Comprobamos si el tipo de imagen es permitido
        if (!in_array($image_type, $image_types)) {
            return ['message' => 'El tipo de imagen no es permitido'];
        }
        // Si todo esta bien retornamos un array vacio
        return [];
    }

    public function validate_file()
    {
        // Comprobamos si el archivo se subio correctamente
        if ($this->image['error'] !== UPLOAD_ERR_OK) {
            return ['message' => 'Error al cargar el archivo'];
        }
        // Comprobamos si el archivo no sobrepasa el tamano maximo
        if ($this->image['size'] > $this->max_size) {
            return ['message' => 'El archivo es muy grande'];
        }
        // Definimos los tipos de archivo permitidos
        $file_types = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];
        // Obtenemos el tipo de archivo
        $file_type = pathinfo($this->image['name'], PATHINFO_EXTENSION);
        // Comprobamos si el tipo de archivo es permitido
        if (!in_array($file_type, $file_types)) {
            return ['message' => 'El tipo de archivo no es permitido'];
        }
        // Si todo esta bien retornamos un array vacio
        return [];
    }
}