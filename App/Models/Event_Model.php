<?php
/**
 * Clase modelo de la tabla eventos, aqui se implementaran todos los metodos
 * requeridos, vease el GET, POST, PUT, DELETE.
 */
namespace App\Models;

class Event_Model extends Model
{

    /**
     * Obtiene los datos de un evento para almacenarlo en la base de datos
     * Creo que guardar los archivos en la misma base de datos no es lo mejor
     * @param mixed $data
     * @param mixed $files
     * @return mixed
     */
    public function post_event($data, $files)
    {
        try {
            //Se conecta a la base de datos
            $this->connect();
            //Se prepara la consulta
            $query = $this->pdo->prepare("INSERT INTO eventos (
            name_event,
            type_event,
            group_events,
            max_participantes,
            date_register,
            date_start,
            date_end,
            hour_start,
            hour_end,
            register_start_date,
            register_end_date,
            description_event,
            thumbnail, 
            sede,
            files,
            aquien_va_dirigido,
            director_CT_only,
            administrative_area_only,
            administrative_area_participants,
            workplace_center_participants,
            event_host,
            email,
            phone_number,
            visible_data_host,
            assigned_host,
            have_event_activity,
            notification_enabled) 
            VALUES (
            :name_event, 
            :type_event, 
            :group_events, 
            :max_participantes, 
            :date_register, 
            :date_start, 
            :date_end, 
            :hour_start, 
            :hour_end, 
            :register_start_date, 
            :register_end_date, 
            :description_event, 
            :thumbnail, 
            :sede, 
            :files, 
            :aquien_va_dirigido, 
            :director_CT_only, 
            :administrative_area_only, 
            :administrative_area_participants,
            :workplace_center_participants, 
            :event_host, 
            :email, 
            :phone_number, 
            :visible_data_host, 
            :assigned_host, 
            :have_event_activity, 
            :notification_enabled)");


            // Se pasan los parametros
            $query->bindParam(':name_event', $data['name_event']);
            $query->bindParam(':type_event', $data['type_event']);
            $query->bindParam(':group_events', $data['group_events']);
            $query->bindParam(':max_participantes', $data['max_participantes']);
            $query->bindParam(':date_register', $data['date_register']);
            $query->bindParam(':date_start', $data['date_start']);
            $query->bindParam(':date_end', $data['date_end']);
            $query->bindParam(':hour_start', $data['hour_start']);
            $query->bindParam(':hour_end', $data['hour_end']);
            $query->bindParam(':register_start_date', $data['register_start_date']);
            $query->bindParam(':register_end_date', $data['register_end_date']);
            $query->bindParam(':description_event', $data['description_event']);
            $query->bindParam(':thumbnail', $files['thumbnail'], \PDO::PARAM_LOB);
            $query->bindParam(':sede', $data['sede']);
            $query->bindParam(':files', $files['files'], \PDO::PARAM_LOB);
            $query->bindParam(':aquien_va_dirigido', $data['aquien_va_dirigido']);
            $query->bindParam(':director_CT_only', $data['director_CT_only']);
            $query->bindParam(':administrative_area_only', $data['administrative_area_only']);
            $query->bindParam(':administrative_area_participants', $data['administrative_area_participants']);
            $query->bindParam(':workplace_center_participants', $data['workplace_center_participants']);
            $query->bindParam(':event_host', $data['event_host']);
            $query->bindParam(':email', $data['email']);
            $query->bindParam(':phone_number', $data['phone_number']);
            $query->bindParam(':visible_data_host', $data['visible_data_host']);
            $query->bindParam(':assigned_host', $data['assigned_host']);
            $query->bindParam(':have_event_activity', $data['have_event_activity']);
            $query->bindParam(':notification_enabled', $data['notification_enabled']);
            //Se ejecuta la consulta
            $query->execute();
            // Se almacena el resultado
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            // Se cierra la conexion
            $this->close();
            // Se retorna el resultado
            return $result;
        } catch (\PDOException $e) {
            echo "Error al crear el evento: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Realiza un consulta general para obtener todos los eventos 
     * que estan almacenado en la base de datos.
     * @return mixed
     */
    public function get_events()
    {
        try {
            // Creamos la coneccion con la base de datos
            $this->connect();
            // Preparamos la consulta
            $query = $this->pdo->prepare("SELECT * FROM eventos");
            // Ejecutamos la consulta
            $query->execute();
            // Almacenamos el resultado
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            // Cerramos la conexion
            $this->close();
            // modificamos el thumbnail y el archivo para que se muestre en el front
            foreach ($result as $key => $value) {
                // Guardamos el thumbnail en el disco
                file_put_contents("/tmp/thumbnail$key.jpg", $value['thumbnail']);
                // Guardamos el archivo en el disco
                file_put_contents("/tmp/files$key.pdf", $value['files']);
                // Guardamos en el resultado la ruta donde se guardo el thumbnail y el archivo
                $result[$key]['thumbnail'] = "/tmp/thumbnail$key.jpg";
                $result[$key]['files'] = "/tmp/files$key.pdf";
            }
            // Retornamos el resultado
            return $result;
        } catch (\PDOException $e) {
            echo "Error al obtener los eventos: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Buscamos si existe algun evento con el id que nos pasen
     * en caso de exista borramos el evento con dicho id y retornamos true,
     * en caso de no exister retornamos false.
     * @param mixed $id
     * @return bool
     */
    public function delete_event($id)
    {
        try {
            // Creamos la coneccion con la base de datos
            $this->connect();
            // Comprobamos primero si existe el evento
            $query = $this->pdo->prepare("SELECT * FROM eventos WHERE id = :id");
            // Ejecutamos la consulta
            $query->execute(array(':id' => $id));
            // Almacenamos el resultado
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            // Si no existe el evento
            if (empty($result)) {
                // Cerramos la conexion
                $this->close();
                // Retornamos el resultado
                return false;
            }
            // Preparamos la consulta
            $query = $this->pdo->prepare("DELETE FROM eventos WHERE id = :id");
            // Ejecutamos la consulta
            $query->execute(array(':id' => $id));
            // Cerramos la conexion
            $this->close();
            // Retornamos el resultado
            return true;
        } catch (\PDOException $e) {
            echo "Error al eliminar el evento: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Buscamos si existe algun evento con el id que nos pasen
     * y retornamos el evento con dicho id.
     * @param mixed $id
     * @return mixed
     */
    public function get_event($id)
    {
        try {
            // Creamos la coneccion con la base de datos
            $this->connect();
            // Preparamos la consulta
            $query = $this->pdo->prepare("SELECT * FROM eventos WHERE id = :id");
            // Ejecutamos la consulta
            $query->execute(array(':id' => $id));
            // Almacenamos el resultado
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            // Si no existe el evento
            if (empty($result)) {
                // Cerramos la conexion
                $this->close();
                // Retornamos el resultado
                return false;
            }
            // Cerramos la conexion
            $this->close();
            // Modificamos el thumbnail y el archivo para que se muestre en el front
            // Guardamos el thumbnail en el disco
            file_put_contents("/tmp/thumbnail.jpg", $result['thumbnail']);
            // Guardamos el archivo en el disco
            file_put_contents("/tmp/files.pdf", $result['files']);
            // Guardamos en el resultado la ruta donde se guardo el thumbnail y el archivo
            $result['thumbnail'] = "/tmp/thumbnail.jpg";
            $result['files'] = "/tmp/files.pdf";
            // Retornamos el resultado
            return $result;
        } catch (\Throwable $th) {
            echo "Error al obtener el evento: " . $th->getMessage();
            return false;
        }
    }

    /**
     * Se modifica un evento con los datos que nos pasen
     * y mediante un id.
     */
    public function put_event($data, $files, $id)
    {
        try {
            //Se conecta a la base de datos
            $this->connect();
            //Se prepara la consulta
            $query = $this->pdo->prepare("UPDATE eventos SET 
            name_event = :name_event,
            type_event = :type_event,
            group_events = :group_events,
            max_participantes = :max_participantes,
            date_register = :date_register,
            date_start = :date_start,
            date_end = :date_end,
            hour_start = :hour_start,
            hour_end = :hour_end,
            register_start_date = :register_start_date,
            register_end_date = :register_end_date,
            description_event = :description_event,
            thumbnail = :thumbnail, 
            sede = :sede,
            files = :files,
            aquien_va_dirigido = :aquien_va_dirigido,
            director_CT_only = :director_CT_only,
            administrative_area_only = :administrative_area_only,
            administrative_area_participants = :administrative_area_participants,
            workplace_center_participants = :workplace_center_participants,
            event_host = :event_host,
            email = :email,
            phone_number = :phone_number,
            visible_data_host = :visible_data_host,
            assigned_host = :assigned_host,
            have_event_activity = :have_event_activity,
            notification_enabled = :notification_enabled 
            WHERE id = :id");

            // Se pasan los parametros
            $query->bindParam(':name_event', $data['name_event']);
            $query->bindParam(':type_event', $data['type_event']);
            $query->bindParam(':group_events', $data['group_events']);
            $query->bindParam(':max_participantes', $data['max_participantes']);
            $query->bindParam(':date_register', $data['date_register']);
            $query->bindParam(':date_start', $data['date_start']);
            $query->bindParam(':date_end', $data['date_end']);
            $query->bindParam(':hour_start', $data['hour_start']);
            $query->bindParam(':hour_end', $data['hour_end']);
            $query->bindParam(':register_start_date', $data['register_start_date']);
            $query->bindParam(':register_end_date', $data['register_end_date']);
            $query->bindParam(':description_event', $data['description_event']);
            $query->bindParam(':thumbnail', $files['thumbnail'], \PDO::PARAM_LOB);
            $query->bindParam(':sede', $data['sede']);
            $query->bindParam(':files', $files['files'], \PDO::PARAM_LOB);
            $query->bindParam(':aquien_va_dirigido', $data['aquien_va_dirigido']);
            $query->bindParam(':director_CT_only', $data['director_CT_only']);
            $query->bindParam(':administrative_area_only', $data['administrative_area_only']);
            $query->bindParam(':administrative_area_participants', $data['administrative_area_participants']);
            $query->bindParam(':workplace_center_participants', $data['workplace_center_participants']);
            $query->bindParam(':event_host', $data['event_host']);
            $query->bindParam(':email', $data['email']);
            $query->bindParam(':phone_number', $data['phone_number']);
            $query->bindParam(':visible_data_host', $data['visible_data_host']);
            $query->bindParam(':assigned_host', $data['assigned_host']);
            $query->bindParam(':have_event_activity', $data['have_event_activity']);
            $query->bindParam(':notification_enabled', $data['notification_enabled']);
            // Se pasa el id que se usara como identificador
            $query->bindParam(':id', $id);
            //Se ejecuta la consulta
            $query->execute();
            // Se almacena el resultado
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            // Se cierra la conexion
            $this->close();
            // Se retorna el resultado
            return $result;
        } catch (\PDOException $e) {
            echo "Error al crear el evento: " . $e->getMessage();
            return false;
        }
    }
}