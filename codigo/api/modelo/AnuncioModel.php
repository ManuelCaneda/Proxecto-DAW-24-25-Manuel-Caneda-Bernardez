<?php
include_once("Model.php");
include_once("ModelObject.php");

class Anuncio extends ModelObject{

    public $id_anuncio;
    public $id_cliente;
    public $imagen;
    public $nombre;
    public $texto;
    public $precio;
    public $estado;

    function __construct($id_cliente, $imagen, $nombre, $texto, $precio, $estado, $id_anuncio=null) {
        $this->id_cliente = $id_cliente;
        $this->imagen = $imagen;
        $this->nombre = $nombre;
        $this->texto = $texto;
        $this->precio = $precio;
        $this->estado = $estado;
        $this->id_anuncio = $id_anuncio;
    }

    public static function fromJson($json):ModelObject{
        $data = json_decode($json);
        return new Anuncio($data->id_anuncio, $data->id_cliente, $data->imagen, $data->nombre, $data->texto, $data->precio);
    }


    public function toJson():String{
        return json_encode($this,JSON_PRETTY_PRINT);
    }

}


class AnuncioModel extends Model
{

    public function getAll()
    {
        $sql = "SELECT * FROM anuncios";
        $pdo = self::getConnection();
        $resultado = [];
        try {
            $statement = $pdo->query($sql);
            $resultado = array();
            foreach($statement as $b){
                $anuncio = new Anuncio($b['id_cliente'], $b['imagen'], $b['nombre'], $b['texto'], $b['precio'], $b['estado'], $b['id_anuncio']);
                $resultado[] = $anuncio;
            }
        } catch (PDOException $th) {
            error_log("Error AnuncioModel->getAll()");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function get($anuncioId):Usuario|null
    {
        $sql = "SELECT * FROM anuncios WHERE id=?";
        $pdo = self::getConnection();
        $resultado = null;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $anuncioId, PDO::PARAM_INT);
            $statement->execute();
            if($b = $statement->fetch()){
                $resultado = new Anuncio($b['id_cliente'], $b['imagen'], $b['nombre'], $b['texto'], $b['precio'], $b['estado'], $b['id_anuncio']);
            }
            
        } catch (Throwable $th) {
            error_log("Error AnuncioModel->get($anuncioId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function insert($anuncio)
    {
        $sql = "INSERT INTO anuncios(id_anuncio,id_cliente,imagen,nombre,texto,precio) VALUES (:id_anuncio, :id_cliente, :imagen, :nombre, :texto, :precio)";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id_anuncio", $anuncio->id_anuncio, PDO::PARAM_INT);
            $statement->bindValue(":id_cliente", $anuncio->id_cliente, PDO::PARAM_INT);
            $statement->bindValue(":imagen", $anuncio->imagen, PDO::PARAM_STR);
            $statement->bindValue(":nombre", $anuncio->nombre, PDO::PARAM_STR);
            $statement->bindValue(":texto", $anuncio->texto, PDO::PARAM_STR);
            $statement->bindValue(":precio", $anuncio->precio, PDO::PARAM_STR);
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error AnuncioModel->insert(" . $anuncio->toJson. ")");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function update($anuncio, $anuncioId)
    {
 
        $sql = "UPDATE anuncios SET
            imagen=:imagen,
            nombre=:nombre,
            texto=:texto,
            precio=:precio,
            WHERE id_anuncio=:id";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":imagen", $anuncio->imagen, PDO::PARAM_STR);
            $statement->bindValue(":nombre", $anuncio->nombre, PDO::PARAM_STR);
            $statement->bindValue(":texto", $anuncio->texto, PDO::PARAM_STR);
            $statement->bindValue(":precio", $anuncio->precio, PDO::PARAM_STR);
            $statement->bindValue(":id", $anuncioId, PDO::PARAM_INT);

            $resultado = $statement->execute();
            $resultado = $statement->rowCount() == 1;
        } catch (PDOException $th) {
            error_log("Error AnuncioModel->update(" . implode(",", $anuncio) . ", $anuncioId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function delete($anuncioId)
    {
        $sql = "DELETE FROM anuncios WHERE id=?";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $anuncioId, PDO::PARAM_INT);
            $resultado = $statement->execute();
        } catch (PDOException $th) {
            error_log("Error AnuncioModel->delete($anuncioId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }
}