<?php
/**
 * Clase para controlar las acciones que tengan que ver con los eventos
 */
namespace APP\Controllers;

//Importamos la clase Image_Validator
use App\Helpers\Validator;
use App\Models\Event_Model;

class Event_Controller
{
    /**
     * Almacena un evento en la base de datos
     * mediante el uso del Event_Model
     * @return array<string>
     */
    public function post_event()
    {
        // Obtenemos los datos de la peticion post
        $data = $_POST;
        // Obtener los archivos
        $files = $_FILES;
        // Instanciamos la clase Validator para validar la imagen
        $image_validator = new Validator($files['thumbnail']);
        // Validamos que el archivo sea una imagen y lo gaurdamos
        // en una variable
        $is_image_valid = $image_validator->validate_image();
        if (!empty($is_image_valid)) {
            return $is_image_valid;
        }
        // Igualamos image_validator e is_image_valid a null
        $image_validator = $is_image_valid = null;
        // Instanciamos la clase Validator para validar el archivo
        $file_validator = new Validator($files['files']);
        // Validamos que el archivo sea un pdf y lo gaurdamos
        // en una variable
        $is_file_valid = $file_validator->validate_file();
        if (!empty($is_file_valid)) {
            return $is_file_valid;
        }
        // Igualamos file_validator e is_file_valid a null
        $file_validator = $is_file_valid = null;
        // creamos un array de los archivos binarios
        $binary_files = [
            "thumbnail" => file_get_contents($files['thumbnail']['tmp_name']),
            "files" => file_get_contents($files['files']['tmp_name']),
        ];
        // Comprobamos que los datos group_events, director_CT_only,
        // administrative_area_only, visible_data_host, have_event_activity
        // y notification_enabled son enum de "Si" o "No"
        if (!$this->validate_enum($data['group_events'])) {
            return ["message" => "El campo group_events debe ser Si o No"];
        }
        if (!$this->validate_enum($data['director_CT_only'])) {
            return ["message" => "El campo director_CT_only debe ser Si o No"];
        }
        if (!$this->validate_enum($data['administrative_area_only'])) {
            return ["message" => "El campo administrative_area_only debe ser Si o No"];
        }
        if (!$this->validate_enum($data['visible_data_host'])) {
            return ["message" => "El campo visible_data_host debe ser Si o No"];
        }
        if (!$this->validate_enum($data['have_event_activity'])) {
            return ["message" => "El campo have_event_activity debe ser Si o No"];
        }
        if (!$this->validate_enum($data['notification_enabled'])) {
            return ["message" => "El campo notification_enabled debe ser Si o No"];
        }
        // remplasamos en data el dato aquien_va_dirigido por el json
        $data['aquien_va_dirigido'] = $this->convert_to_json($data['aquien_va_dirigido']);
        // Instanciamos la clase Event_Model
        $event_model = new Event_Model();
        // Guardamos el evento
        $result = $event_model->post_event($data, $binary_files);
        // Comprobamos que el resultado sea un array, en caso contrario mandamos un error
        if (!is_array($result)) {
            return ["message" => "Error al almacenar los datos"];
        }
        // Retornamos el resultado
        return ["message" => "Datos almacenados"];
    }

    /**
     * Metodo para obtener todos los eventos que estan almacenados en la base de datos
     * @return mixed
     */
    public function get_events()
    {
        // Creamos una instancia de Event_Model
        $event_model = new Event_Model();
        // Obtenemos los eventos
        $events = $event_model->get_events();
        // Comprobamos que el resultado no sea false, porque si no exite un error al almacenar obtener los datos
        if (!$events) {
            return ["message" => "Error al obtener los datos"];
        }
        // Convertimos los thumbnails a base64 y los archivos a base64
        foreach ($events as $key => $event) {
            $events[$key]['thumbnail'] = base64_encode(file_get_contents($event['thumbnail']));
            $events[$key]['files'] = base64_encode(file_get_contents($event['files']));
            // Convertimos el json de aquien_va_dirigido a un array
            $events[$key]['aquien_va_dirigido'] = json_decode($event['aquien_va_dirigido'], true);
        }
        $comilla = '"';
        ## echo "<div>";
        ## echo "<p>Imagen</p>";
        ## echo "<img src=" . "$comilla" . "data:image/jpg;base64, " . $events[0]['thumbnail'] . "$comilla " . " alt=" . "$comilla" . "Red dot" . "$comilla" . " />";
        ## echo "</div>";
        // Imprimir pdf
        ## echo "<div>";
        ## echo "<p>pdf</p>";
        ## echo "<embed src=" . "$comilla" . "data:application/pdf;base64, " . $events[0]['files'] . "$comilla " . " width=100% height=100%" . "$comilla" . "Red dot" . "$comilla" . " />";
        ## echo "</div>";
        // Retornamos los eventos
        return $events;
    }

    /**
     * funcion para eliminar un evento mediante el id
     * creando una instancia de Event_Model
     * @param mixed $id
     * @return array<string>
     */
    public function delete_event($id)
    {
        // Instanciamos la clase Event_Model
        $event_model = new Event_Model();
        // Eliminamos el evento
        $result = $event_model->delete_event($id);
        // Comprobamos que el resultado no sea false
        if (!$result) {
            return ["message" => "Error al eliminar los datos"];
        }
        // Retornamos el resultado
        return ["message" => "Datos eliminados"];
    }

    /**
     * Regresa solo un evento mediante el id proporcionado.
     * @param mixed $id
     * @return mixed
     */
    public function get_event($id)
    {
        // Instanciamos la clase Event_Model
        $event_model = new Event_Model();
        // Obtenemos el evento
        $event = $event_model->get_event($id);
        // Comprobamos que el resultado no sea false
        if (!$event) {
            return ["message" => "Error al obtener los datos"];
        }
        // Convertimos los thumbnails a base64 y los archivos a base64
        $event['thumbnail'] = base64_encode(file_get_contents($event['thumbnail']));
        $event['files'] = base64_encode(file_get_contents($event['files']));
        // Convertimos el json de aquien_va_dirigido a un array
        $event['aquien_va_dirigido'] = json_decode($event['aquien_va_dirigido'], true);
        $comilla = '"';
        echo "<div>";
        echo "<p>Imagen</p>";
        echo "<img src=" . "$comilla" . "data:image/jpg;base64, " . $event['thumbnail'] . "$comilla " . " alt=" . "$comilla" . "Red dot" . "$comilla" . " />";
        echo "</div>";
        //Imprimir pdf
        echo "<div>";
        echo "<p>pdf</p>";
        echo "<embed src=" . "$comilla" . "data:application/pdf;base64, " . $event['files'] . "$comilla " . " width=100% height=100%" . "$comilla" . "Red dot" . "$comilla" . " />";
        echo "</div>";
        //Retornamos el evento
        return $event;

    }

    /**
     * Modifica un evento mediante el id proporcionado.
     */
    public function update_event($id)
    {
        // Obtenemos los datos de la peticion post
        $data = $_POST;
        // Obtener los archivos
        $files = $_FILES;
        // Instanciamos la clase Validator para validar la imagen
        $image_validator = new Validator($files['thumbnail']);
        // Validamos que el archivo sea una imagen y lo gaurdamos
        // en una variable
        $is_image_valid = $image_validator->validate_image();
        if (!empty($is_image_valid)) {
            return $is_image_valid;
        }
        // Igualamos image_validator e is_image_valid a null
        $image_validator = $is_image_valid = null;
        // Instanciamos la clase Validator para validar el archivo
        $file_validator = new Validator($files['files']);
        // Validamos que el archivo sea un pdf y lo gaurdamos
        // en una variable
        $is_file_valid = $file_validator->validate_file();
        if (!empty($is_file_valid)) {
            return $is_file_valid;
        }
        // Igualamos file_validator e is_file_valid a null
        $file_validator = $is_file_valid = null;
        // creamos un array de los archivos binarios
        $binary_files = [
            "thumbnail" => file_get_contents($files['thumbnail']['tmp_name']),
            "files" => file_get_contents($files['files']['tmp_name']),
        ];
        // Comprobamos que los datos group_events, director_CT_only,
        // administrative_area_only, visible_data_host, have_event_activity
        // y notification_enabled son enum de "Si" o "No"
        if (!$this->validate_enum($data['group_events'])) {
            return ["message" => "El campo group_events debe ser Si o No"];
        }
        if (!$this->validate_enum($data['director_CT_only'])) {
            return ["message" => "El campo director_CT_only debe ser Si o No"];
        }
        if (!$this->validate_enum($data['administrative_area_only'])) {
            return ["message" => "El campo administrative_area_only debe ser Si o No"];
        }
        if (!$this->validate_enum($data['visible_data_host'])) {
            return ["message" => "El campo visible_data_host debe ser Si o No"];
        }
        if (!$this->validate_enum($data['have_event_activity'])) {
            return ["message" => "El campo have_event_activity debe ser Si o No"];
        }
        if (!$this->validate_enum($data['notification_enabled'])) {
            return ["message" => "El campo notification_enabled debe ser Si o No"];
        }
        // remplasamos en data el dato aquien_va_dirigido por el json
        $data['aquien_va_dirigido'] = $this->convert_to_json($data['aquien_va_dirigido']);
        // Instanciamos la clase Event_Model
        $event_model = new Event_Model();
        // Guardamos el evento
        $result = $event_model->put_event($data, $binary_files, $id);
        // Comprobamos que el resultado sea un array, en caso contrario mandamos un error
        if (!is_array($result)) {
            return ["message" => "Error al modificar los datos"];
        }
        // Retornamos el resultado
        return ["message" => "Datos modificados"];
    }

    /**
     * tranforma un string con datos separados por coma 
     * a un json con las llaves con los datos y como valor true (1)
     * @param mixed $data
     */
    private function convert_to_json($data)
    {
        // Separamos por comas el dato aquien_va_dirigido y lo convertimos en un array
        $separated_data = explode(",", $data);
        // Invertimos las llaves por los valores
        $separated_data = array_flip($separated_data);
        // cambiamos el valor por true
        $separated_data = array_map(function ($item) {
            return true;
        }, $separated_data);
        // lo convertimos a json
        return json_encode($separated_data);
    }


    /**
     * Funcion para validar si el enum es "Si" o "No"
     * @param mixed $value
     * @return bool
     */
    private function validate_enum($value)
    {
        // Validamos que el valor sea "Si" o "No"
        if ($value == "Si" || $value == "No") {
            // Retornamos true
            return true;
        }
        // Retornamos false
        return false;
    }
}