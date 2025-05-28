<?php
include_once("Model.php");
include_once("ModelObject.php");

class Valoracion extends ModelObject{

    public $id;
    public $id_anuncio;
    public $id_usuario;
    public $puntuacion;
    public $texto;

    function __construct($id_anuncio, $id_usuario, $puntuacion, $texto, $id=null) {
        $this->id_anuncio = $id_anuncio;
        $this->id_usuario = $id_usuario;
        $this->puntuacion = $puntuacion;
        $this->texto = $texto;
        $this->id = $id;
    }

    public static function fromJson($json):ModelObject{
        $data = json_decode($json);
        return new Valoracion($data->id_anuncio, $data->id_usuario, $data->puntuacion, $data->texto, $data->id??null);
    }


    public function toJson():String{
        return json_encode($this,JSON_PRETTY_PRINT);
    }

}


class ValoracionModel extends Model
{

    public function getAll()
    {
        $sql = "SELECT * FROM valoraciones";
        $pdo = self::getConnection();
        $resultado = [];
        try {
            $statement = $pdo->query($sql);
            $resultado = array();
            foreach($statement as $b){
                $valoracion = new Valoracion($b['id_anuncio'], $b['id_usuario'], $b['puntuacion'], $b['texto'], $b['id']);
                $resultado[] = $valoracion;
            }
        } catch (PDOException $th) {
            error_log("Error ValoracionModel->getAll()");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function get($valoracionId)
    {
        $sql = "SELECT * FROM valoraciones WHERE id_anuncio=?";
        $pdo = self::getConnection();
        $resultado = null;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $valoracionId[0], PDO::PARAM_INT);
            $statement->execute();
            if($b = $statement->fetch()){
                $resultado = new Valoracion($b['id_anuncio'], $b['id_usuario'], $b['puntuacion'], $b['texto'], $b['id']);
            }
            
        } catch (Throwable $th) {
            error_log("Error ValoracionModel->get($valoracionId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function getByAnuncio($id)
    {
        $sql = "SELECT v.id, v.id_anuncio, CONCAT(u.nombre, ' ', u.apellidos) as nombre_autor, v.puntuacion, v.texto
                FROM valoraciones v, usuarios u
                WHERE v.id_usuario=u.id
                AND id_anuncio=?";
        $pdo = self::getConnection();
        $resultados = [];

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $id[0], PDO::PARAM_STR);
            $statement->execute();

            while ($b = $statement->fetch(PDO::FETCH_ASSOC)) {
                $resultados[] = new Valoracion(
                    $b['id_anuncio'] ?? null,
                    $b['nombre_autor'] ?? null,    
                    $b['puntuacion'] ?? null,
                    $b['texto'] ?? null,
                    $b['id'] ?? null
                );
            }

        } catch (Throwable $th) {
            error_log("Error ValoracionModel->getByAnuncio($id[0])");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultados;
    }

    public function getByAutor($id)
    {
        $sql = "SELECT v.id, v.id_anuncio, CONCAT(u.nombre, ' ', u.apellidos) as nombre_autor, v.puntuacion, v.texto
                FROM valoraciones v, usuarios u
                WHERE v.id_usuario=u.id
                AND v.id_usuario=?";
        $pdo = self::getConnection();
        $resultados = [];

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $id[0], PDO::PARAM_STR);
            $statement->execute();

            while ($b = $statement->fetch(PDO::FETCH_ASSOC)) {
                $resultados[] = new Valoracion(
                    $b['id_anuncio'] ?? null,
                    $b['nombre_autor'] ?? null,    
                    $b['puntuacion'] ?? null,
                    $b['texto'] ?? null,
                    $b['id'] ?? null
                );
            }

        } catch (Throwable $th) {
            error_log("Error ValoracionModel->getByAutor($id[0])");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultados;
    }

    public function insert($valoracion)
    {
        $sql = "INSERT INTO valoraciones(id_anuncio, id_usuario, puntuacion, texto)
        VALUES (:id_anuncio, :id_usuario, :puntuacion, :texto)";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id_anuncio", $valoracion->id_anuncio, PDO::PARAM_INT);
            $statement->bindValue(":id_usuario", $valoracion->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(":puntuacion", $valoracion->puntuacion, PDO::PARAM_INT);
            $statement->bindValue(":texto", $valoracion->texto, PDO::PARAM_STR);
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error ValoracionModel->insert(" . $valoracion->toJson. ")");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function update($valoracion, $valoracionId)
    { 
        $sql = "UPDATE anuncios SET
            id_anuncio=:id_anuncio,
            id_usuario=:id_usuario,
            puntuacion=:puntuacion,
            texto=:texto
            WHERE id_anuncio=:id";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id_anuncio", $valoracion->id_anuncio, PDO::PARAM_INT);
            $statement->bindValue(":id_usuario", $valoracion->id_usuario, PDO::PARAM_INT);
            $statement->bindValue(":puntuacion", $valoracion->puntuacion, PDO::PARAM_INT);
            $statement->bindValue(":texto", $valoracion->texto, PDO::PARAM_STR);
            $statement->bindValue(":id", $valoracionId, PDO::PARAM_INT);

            $resultado = $statement->execute();
            $resultado = $statement->rowCount() == 1;
        } catch (PDOException $th) {
            error_log("Error ValoracionModel->update(" . json_encode($valoracion) . ", $valoracionId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function delete($valoracionId)
    {
        $sql = "DELETE FROM valoraciones
                WHERE id=?";
        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $valoracionId, PDO::PARAM_INT);
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error ValoracionModel->delete($valoracionId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }
}