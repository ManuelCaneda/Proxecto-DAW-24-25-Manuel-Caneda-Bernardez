<?php
class AuthModel
{
    private static function getConnection()
    {
        $pdo = null;
        try {
            $pdo = new PDO("mysql:host=mariadb;dbname=control_acceso", DB_USER, DB_PASS);
        } catch (PDOException $e) {
            error_log("Error conectando a la base de datos...");
            error_log($e->getMessage());
        }
        return $pdo;
    }

    public static function hasAccess($endpoint, $method, $token): bool
    {
        $sql = "SELECT *
        FROM autorizacion a
        INNER JOIN permiso p ON a.permiso_id = p.id
        INNER JOIN endpoint e ON e.id = a.endpoint_id
        WHERE a.token = :token AND e.uri = :endpoint AND p.nombre = :method";
        $pdo = self::getConnection();
        $statement = $pdo->prepare($sql);
        $access = false;
        try {
            $statement->bindValue(':endpoint',$endpoint, PDO::PARAM_STR);
            $statement->bindValue(':method',$method, PDO::PARAM_STR);
            $statement->bindValue(':token',$token, PDO::PARAM_STR);
            $access = $statement->execute();
            $access = $statement->rowCount() >= 1;
        } catch (PDOException $th) {
            error_log("Error en la consulta de autenticacion ($token , $endpoint, $method)");
            $access = false;
        }finally{
            $statement = null;
            $pdo = null;
        }

        return $access;
    }
}