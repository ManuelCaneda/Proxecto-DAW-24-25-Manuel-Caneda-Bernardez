<?php
include_once("Controller.php");
include_once(PATH_MODEL."MensajeModel.php");

//die(PATH_MODEL."MensajeModel.php");   

function sanitizeMensaje($m) {
    return [
        'id' => $m->id,
        'id_emisor' => $m->id_emisor,
        'id_receptor' => $m->id_receptor,
        'fecha' => $m->fecha,
        'hora' => $m->hora,
        'texto' => mb_convert_encoding($m->texto, 'UTF-8', 'UTF-8')
    ];
} 

class MensajeController extends Controller{

    public function get($ids) {
        $model = new MensajeModel();
        $mensaje = $model->get($ids);

        if($mensaje==null){
            Controller::sendNotFound("Los ids no corresponden con ningún mensaje");
            die();
        }

        echo json_encode(sanitizeMensaje($mensaje),JSON_PRETTY_PRINT);
    }   

    public function getAll() {
        $model = new MensajeModel();
        $mensajes = $model->getAll();

        $usuarios_array = [];

        foreach ($mensajes as $m) {
            $usuarios_array[] = sanitizeMensaje($m);
        }
    
        echo json_encode($usuarios_array, JSON_PRETTY_PRINT);
    }

    public function insert($object){
        $model = new MensajeModel();
        $mensaje = Mensaje::fromJson($object);
        if($model->insert($mensaje)){
            echo json_encode(["msg" => "Mensaje insertado."],JSON_PRETTY_PRINT);
        }else{
            Controller::sendNotFound("No se ha podido insertar");
        }

    }
    
    public function delete($id) {
        $model = new MensajeModel();
        if($model->delete($id[0])){
            echo json_encode(["msg" => "Mensaje eliminado."],JSON_PRETTY_PRINT);
        }else{
            Controller::sendNotFound("No se ha podido eliminar");
        }
    }
    public function update($id, $object){
        $model = new MensajeModel();
        $mensaje = Mensaje::fromJson($object);

        if($model->update($mensaje,$id)){
            echo json_encode(["msg" => "Mensaje modificado."],JSON_PRETTY_PRINT);
        } else {
            Controller::sendNotFound("No se ha podido modificar");
        }
    }
}