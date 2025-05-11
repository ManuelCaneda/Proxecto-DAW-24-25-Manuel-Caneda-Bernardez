<?php
require_once('bbdd.php');

class Usuario{
    public $id;
    public $nombre;
    public $aps;
    public $email;
    public $pass;

    public function __construct($nombre,$aps,$email,$pass,$id=null){
        $this->nombre = $nombre;
        $this->aps = $aps;
        $this->email = $email;
        $this->pass = $pass;
        $this->id = $id;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of aps
     */ 
    public function getAps()
    {
        return $this->aps;
    }

    /**
     * Set the value of aps
     *
     * @return  self
     */ 
    public function setAps($aps)
    {
        $this->aps = $aps;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of pass
     */ 
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set the value of pass
     *
     * @return  self
     */ 
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }
}

class UsuarioModel {
    public function get($email,$pass){
        $pass = sha1($pass);
        
        $pdo = BBDD::getConnection();
        $sql = "SELECT id, nombre, apellidos, email, pass FROM usuarios
                WHERE email = ? 
                AND pass = ?";

        $user = null;
        
        try{
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $email);
            $statement->bindValue(2, $pass);
            
            $statement->execute();
            
            if($row = $statement->fetch()){
                $user = new Usuario($row["nombre"],$row["apellidos"],$row["email"],$row["pass"],$row["id"]);
            }
        } catch (PDOException $e) {
            error_log("Error al obtener el usuario: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $user;
    }

    public function getById($id){
        $pdo = BBDD::getConnection();
        $sql = "SELECT id, nombre, apellidos, email, pass FROM usuarios
                WHERE id = ?";

        $user = null;
        
        try{
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $id);
            
            $statement->execute();
            
            if($row = $statement->fetch()){
                $user = new Usuario($row["nombre"],$row["apellidos"],$row["email"],$row["pass"],$row["id"]);
            }
        } catch (PDOException $e) {
            error_log("Error al obtener el usuario: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $user;
    }

    public function add(Usuario $user){        
        $pdo = BBDD::getConnection();

        $sql = "INSERT INTO usuarios (nombre, apellidos, email, pass, tipo_usuario) 
                VALUES (:nombre, :aps, :email, :pass,2)";

        $toret = false;
        try{
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":nombre", $user->getNombre());
            $statement->bindValue(":aps", $user->getAps());
            $statement->bindValue(":email", $user->getEmail());
            $statement->bindValue(":pass", sha1($user->getPass()));

            $statement->execute();
            $toret = $statement->rowCount()>0;
        } catch (PDOException $e) {
            error_log("Error al insertar el usuario: " . $e->getMessage());
        } finally {
            $pdo = null;
            $statement = null;
        }

        return $toret;
    }
}