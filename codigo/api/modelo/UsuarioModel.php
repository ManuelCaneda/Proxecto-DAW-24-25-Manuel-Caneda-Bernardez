<?php
include_once("Model.php");
include_once("ModelObject.php");

class Usuario extends ModelObject{

    public $id;
    public $nombre;
    public $apellidos;
    public $email;
    public $pass;
    public $tipo;

    function __construct($nombre, $apellidos, $email, $pass, $tipo, $id=null) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->pass = $pass;
        $this->tipo = $tipo;
        $this->id = $id;
    }

    public static function fromJson($json):ModelObject{
        $data = json_decode($json);
        return new Usuario($data->nombre, $data->apellidos, $data->email, $data->pass, $data->tipo,$data->id);
    }


    public function toJson():String{
        return json_encode($this,JSON_PRETTY_PRINT);
    }

}


class UsuarioModel extends Model
{

    public function getAll()
    {
        $sql = "SELECT * FROM usuarios";
        $pdo = self::getConnection();
        $resultado = [];
        try {
            $statement = $pdo->query($sql);
            $resultado = array();
            foreach($statement as $b){
                $usuario = new Usuario($b['nombre'], $b['apellidos'], $b['email'], $b['pass'], $b['tipo_usuario'], $b['id']);
                $resultado[] = $usuario;
            }
        } catch (PDOException $th) {
            error_log("Error UsuarioModel->getAll()");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function get($usuarioId):Usuario|null
    {
        $sql = "SELECT * FROM usuarios WHERE id=?";
        $pdo = self::getConnection();
        $resultado = null;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $usuarioId[0], PDO::PARAM_INT);
            $statement->execute();
            if($b = $statement->fetch()){
                $resultado = new Usuario($b['nombre'], $b['apellidos'], $b['email'], $b['pass'], $b['tipo_usuario'], $b['id']);
            }
            
        } catch (Throwable $th) {
            error_log("Error UsuarioModel->get($usuarioId[0])");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function getContactos($usuarioId):array|null
    {
        $sql = "SELECT DISTINCT u.*
                FROM mensajes m, usuarios u
                WHERE (m.id_emisor=u.id OR m.id_receptor=u.id)
                AND (m.id_emisor=? OR m.id_receptor=?)
                AND u.id != ?";
        $pdo = self::getConnection();
        $resultado = [];
        
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $usuarioId, PDO::PARAM_INT);
            $statement->bindValue(2, $usuarioId, PDO::PARAM_INT);
            $statement->bindValue(3, $usuarioId, PDO::PARAM_INT);
            
            $statement->execute();
            $query = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($query as $b){
                $contacto = new Usuario($b['id'], $b['nombre'], $b['apellidos'], $b['email'], $b['pass'], $b['tipo_usuario']);
                $resultado[] = $contacto;
            }
            
        } catch (Throwable $th) {
            error_log("Error UsuarioModel->getContactos($usuarioId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function insert($usuario)
    {
        $sql = "INSERT INTO usuarios(id,nombre,apellidos,email,pass,tipo) VALUES (:id, :nombre, :apellidos, :email, :pass, :tipo)";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id", $usuario->id, PDO::PARAM_INT);
            $statement->bindValue(":nombre", $usuario->nombre, PDO::PARAM_INT);
            $statement->bindValue(":apellidos", $usuario->apellidos, PDO::PARAM_STR);
            $statement->bindValue(":email", $usuario->email, PDO::PARAM_INT);
            $statement->bindValue(":pass", $usuario->pass, PDO::PARAM_INT);
            $statement->bindValue(":tipo", $usuario->tipo, PDO::PARAM_INT);
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error UsuarioModel->insert(" . $usuario->toJson. ")");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function update($usuario, $usuarioId)
    {
 
        $sql = "UPDATE usuarios SET
            nombre=:nombre,
            apellidos=:apellidos,
            email=:email
            WHERE id=:id";

        $pdo = self::getConnection();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $resultado = false;

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":nombre", $usuario->nombre, PDO::PARAM_STR);
            $statement->bindValue(":apellidos", $usuario->apellidos, PDO::PARAM_STR);
            $statement->bindValue(":email", $usuario->email, PDO::PARAM_STR);
            $statement->bindValue(":id", $usuarioId[0], PDO::PARAM_INT);
            
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error UsuarioModel->update(" . implode(",", $usuario) . ", $usuarioId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function delete($usuarioId)
    {
        $sql = "DELETE FROM usuarios WHERE id=?";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $usuarioId[0], PDO::PARAM_INT);
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error UsuarioModel->delete($usuarioId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }
}