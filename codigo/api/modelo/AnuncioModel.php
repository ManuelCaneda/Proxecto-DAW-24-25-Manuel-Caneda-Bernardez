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
        return new Anuncio(isset($data->id_cliente)?$data->id_cliente:null, isset($data->imagen)?$data->imagen:"http://proyecto.local/uploads/anuncio_img_default.png", $data->nombre, $data->texto, $data->precio, isset($data->estado)?$data->estado:"dev", isset($data->id_anuncio)?$data->id_anuncio:null);
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

    public function getPublicados($limit)
    {
        $sql = "SELECT CONCAT(u.nombre, ' ', u.apellidos) as autor, a.imagen, a.nombre, a.texto, a.precio, a.estado, a.id_anuncio
                FROM anuncios a, usuarios u
                WHERE a.id_cliente=u.id
                AND estado='publicado'
                ORDER BY RAND()
                LIMIT $limit";
        $pdo = self::getConnection();
        $resultado = [];
        try {
            $statement = $pdo->query($sql);
            $resultado = array();
            foreach($statement as $b){
                $anuncio = ['autor' => mb_convert_encoding($b['autor'], 'UTF-8', 'UTF-8'),
                            'imagen' => mb_convert_encoding($b['imagen'], 'UTF-8', 'UTF-8'),
                            'nombre' => mb_convert_encoding($b['nombre'], 'UTF-8', 'UTF-8'),
                            'texto' => mb_convert_encoding($b['texto'], 'UTF-8', 'UTF-8'),
                            'precio' => $b['precio'],
                            'estado' => $b['estado'],
                            'id_anuncio' => $b['id_anuncio']];
                $resultado[] = $anuncio;
            }
        } catch (PDOException $th) {
            error_log("Error AnuncioModel->getPublicados()");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function get($anuncioId)
    {
        $sql = "SELECT * FROM anuncios WHERE id_anuncio=?";
        $pdo = self::getConnection();
        $resultado = null;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $anuncioId[0], PDO::PARAM_INT);
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


    public function getBySearch($search): array
    {
        $sql = "SELECT a.*, concat(u.nombre, ' ', u.apellidos) as autor
                FROM anuncios a, usuarios u
                WHERE a.id_cliente=u.id
                AND LOWER(a.nombre) LIKE LOWER(?)";

        $pdo = self::getConnection();
        $resultados = [];

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, '%' . $search . '%', PDO::PARAM_STR);
            $statement->execute();

            while ($b = $statement->fetch(PDO::FETCH_ASSOC)) {
                $resultados[] = [
                    'autor' => mb_convert_encoding($b['autor'], 'UTF-8', 'UTF-8') ?? null,
                    'imagen' => mb_convert_encoding($b['imagen'], 'UTF-8', 'UTF-8') ?? null,
                    'nombre' => mb_convert_encoding($b['nombre'], 'UTF-8', 'UTF-8') ?? null,
                    'texto' => mb_convert_encoding($b['texto'], 'UTF-8', 'UTF-8') ?? null,
                    'precio' => $b['precio'] ?? null,
                    'estado' => $b['estado'] ?? null,
                    'id_anuncio' => $b['id_anuncio'] ?? null,
                ];
            }

        } catch (Throwable $th) {
            error_log("Error AnuncioModel->getBySearch($search)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultados;
    }

    public function getByCliente($anuncioId)
    {
        $sql = "SELECT * FROM anuncios WHERE id_cliente=?";
        $pdo = self::getConnection();
        $resultados = [];

        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $anuncioId[0], PDO::PARAM_STR);
            $statement->execute();

            while ($b = $statement->fetch(PDO::FETCH_ASSOC)) {
                $resultados[] = new Anuncio(
                    $b['id_cliente'] ?? null,
                    $b['imagen'] ?? null,
                    $b['nombre'] ?? null,
                    $b['texto'] ?? null,
                    $b['precio'] ?? null,
                    $b['estado'] ?? null,
                    $b['id_anuncio'] ?? null
                );
            }

        } catch (Throwable $th) {
            error_log("Error AnuncioModel->getByCliente($anuncioId[0])");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultados;
    }

    public function insert($anuncio)
    {
        $sql = "INSERT INTO anuncios(id_cliente,imagen,nombre,texto,precio)
        VALUES (:id_cliente, :imagen, :nombre, :texto, :precio)";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
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
            estado=:estado
            WHERE id_anuncio=:id";

        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":imagen", $anuncio->imagen, PDO::PARAM_STR);
            $statement->bindValue(":nombre", $anuncio->nombre, PDO::PARAM_STR);
            $statement->bindValue(":texto", $anuncio->texto, PDO::PARAM_STR);
            $statement->bindValue(":precio", $anuncio->precio, PDO::PARAM_STR);
            $statement->bindValue(":estado", $anuncio->estado, PDO::PARAM_STR);
            $statement->bindValue(":id", $anuncioId, PDO::PARAM_INT);

            $resultado = $statement->execute();
            $resultado = $statement->rowCount() == 1;
        } catch (PDOException $th) {
            error_log("Error AnuncioModel->update(" . json_encode($anuncio) . ", $anuncioId)");
            error_log($th->getMessage());
        } finally {
            $statement = null;
            $pdo = null;
        }

        return $resultado;
    }

    public function delete($anuncioId)
    {
        $sql = "DELETE FROM anuncios WHERE id_anuncio=?;
                DELETE FROM valoraciones WHERE id_anuncio=?;";
        $pdo = self::getConnection();
        $resultado = false;
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $anuncioId, PDO::PARAM_INT);
            $statement->bindValue(2, $anuncioId, PDO::PARAM_INT);
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