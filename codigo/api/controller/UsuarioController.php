<?php
include_once("Controller.php");
include_once(PATH_MODEL."UsuarioModel.php");

//die(PATH_MODEL."UsuarioModel.php");   

function sanitizeUsuario($u) {
    return [
        'id' => $u->id,
        'nombre' => mb_convert_encoding($u->nombre, 'UTF-8', 'UTF-8'),
        'apellidos' => mb_convert_encoding($u->apellidos, 'UTF-8', 'UTF-8'),
        'email' => mb_convert_encoding($u->email, 'UTF-8', 'UTF-8'),
        'tipo' => $u->tipo
    ];
} 

class UsuarioController extends Controller{

    public function get($id){
        $model = new UsuarioModel();
        $usuario = $model->get($id);

        if($usuario==null){
            Controller::sendNotFound("El id no se corresponde con ningún usuario");
            die();
        }

        echo json_encode(sanitizeUsuario($usuario),JSON_PRETTY_PRINT);
    }

    public function getContactos($id) {
        $model = new UsuarioModel();
        $contactos = $model->getContactos($id[0]);
        
        if($contactos==null){
            Controller::sendNotFound("El id no se corresponde con ningún usuario o no tiene mensajes");
            die();
        }
        
        $contactos_array = [];
        
        foreach ($contactos as $c) {
            
            $contactos_array[] = sanitizeUsuario($c);
        }
        
        echo json_encode($contactos_array, JSON_PRETTY_PRINT);
    }

    public function getAll() {
        $model = new UsuarioModel();
        $usuarios = $model->getAll();

        $usuarios_array = [];

        foreach ($usuarios as $u) {
            $usuarios_array[] = sanitizeUsuario($u);
        }
    
        echo json_encode($usuarios_array, JSON_PRETTY_PRINT);
    }

    public function insert($object){
        $model = new UsuarioModel();
        $usuario = Usuario::fromJson($object);
        if($model->insert($usuario)){
            echo json_encode(["msg" => "Usuario insertado."],JSON_PRETTY_PRINT);
        }else{
            Controller::sendNotFound("No se ha podido insertar");
        }

    }
    
    public function delete($id) {
        $model = new UsuarioModel();
        if($model->delete($id[0])){
            echo json_encode(["msg" => "Usuario eliminado."],JSON_PRETTY_PRINT);
        }else{
            Controller::sendNotFound("No se ha podido eliminar");
        }
    }
    public function update($id, $object){
        $model = new UsuarioModel();
        $usuario = Usuario::fromJson($object);

        if($model->update($usuario,$id)){
            echo json_encode(["msg" => "Usuario modificado."],JSON_PRETTY_PRINT);
        } else {
            Controller::sendNotFound("No se ha podido modificar");
        }
    }
}