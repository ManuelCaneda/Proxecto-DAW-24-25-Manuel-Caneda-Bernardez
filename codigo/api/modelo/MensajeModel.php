<?php
include_once("Model.php");
include_once("ModelObject.php");

class Mensaje extends ModelObject{

    public $id;
    public $id_emisor;
    public $id_receptor;
    public $fecha;
    public $hora;
    public $texto;

    function __construct($id_emisor, $id_receptor, $texto, $id = null, $fecha= null, $hora = null) {
        $this->id_emisor = $id_emisor;
        $this->id_receptor = $id_receptor;
        $this->texto = $texto;
        if(isset($id))
            $this->id = $id;
        if(isset($fecha))
            $this->fecha = $fecha;
        if(isset($hora))
            $this->hora = $hora;
    }

    public static function fromJson($json):ModelObject{
        $data = json_decode($json);
        return new Mensaje($data->id_emisor, $data->id_receptor, $data->texto, $data->id??null,$data->fecha??null, $data->hora??null);
    }


    public function toJson():String{
        return json_encode($this,JSON_PRETTY_PRINT);
    }

}


class MensajeModel extends Model
{

    public function getAll()
    {
        $sql = "SELECT * FROM mensajes ORDER BY fecha,hora";
        $pdo = self::getConnection();
        $resultado = [];
        try {
            $statement = $pdo->query($sql);
            $resultado = array();
            foreach($statement as $b){
                $mensaje = new Mensaje($b['id_emisor'], 
                $b['id_receptor'],
                 $b['texto'], 
                 $b['id'],
                 $b['fecha'],
                 $b['hora']);
                $resultado[] = $mensaje;
            }
        } catch (PDOException $th) {
            error_log("Error MensajeModel->getAll()");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function get(array $ids):Mensaje|null
    {
        $sql = "SELECT * FROM mensajes WHERE id_emisor=? AND id_receptor=?";
        $pdo = self::getConnection();
        $resultado = null;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $ids[0], PDO::PARAM_INT);
            $statement->bindValue(2, $ids[1], PDO::PARAM_INT);
            $statement->execute();
            if($b = $statement->fetch()){
                $resultado = new Mensaje($b['id_emisor'],
                 $b['id_receptor'],
                  $b['texto'],
                  $b['id'],
                  $b['fecha'],
                     $b['hora']);
            }
            
        } catch (Throwable $th) {
            error_log("Error MensajeModel->get($ids[0], $ids[1])");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function insert($mensaje)
    {
        $sql = "INSERT INTO mensajes(id_emisor,id_receptor,texto) VALUES (:id_emisor, :id_receptor, :texto)";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id_emisor", $mensaje->id_emisor, PDO::PARAM_INT);
            $statement->bindValue(":id_receptor", $mensaje->id_receptor, PDO::PARAM_INT);
            $statement->bindValue(":texto", $mensaje->texto, PDO::PARAM_STR);
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error MensajeModel->insert(" . $mensaje->toJson. ")");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function update($mensaje, $mensajeId)
    { 
        return ["mensaje"=>"No se puede modificar un mensaje"];
        // $sql = "UPDATE mensajes SET
        //     nombre=:nombre,
        //     apellidos=:apellidos,
        //     email=:email
        //     WHERE id=:id";

        // $pdo = self::getConnection();
        // $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // $resultado = false;

        // try {
        //     $statement = $pdo->prepare($sql);
        //     $statement->bindValue(":nombre", $mensaje->nombre, PDO::PARAM_STR);
        //     $statement->bindValue(":apellidos", $mensaje->apellidos, PDO::PARAM_STR);
        //     $statement->bindValue(":email", $mensaje->email, PDO::PARAM_STR);
        //     $statement->bindValue(":id", $mensajeId, PDO::PARAM_INT);
            
        //     $resultado = $statement->execute();
        // } catch (PDOException $th) {
        //     error_log("Error MensajeModel->update(" . implode(",", $mensaje) . ", $mensajeId)");
        //     error_log($th->getMessage());
        // } finally {
        //     $statement = null;
        //     $pdo = null;
        // }

        // return $resultado;
    }

    public function delete($mensajeId)
    {
        $sql = "DELETE FROM mensajes WHERE id=?";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $mensajeId, PDO::PARAM_INT);
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error MensajeModel->delete($mensajeId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }
}
