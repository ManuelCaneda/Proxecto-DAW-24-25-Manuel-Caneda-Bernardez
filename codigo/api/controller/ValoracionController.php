<?php
include_once("Controller.php");
include_once(PATH_MODEL."ValoracionModel.php");

//die(PATH_MODEL."ValoracionModel.php");   

function sanitizeValoracion($a) {
    return [
        'id' => $a->id,
        'id_anuncio' => $a->id_anuncio,
        'id_usuario' => $a->id_usuario,
        'texto' => mb_convert_encoding($a->texto, 'UTF-8', 'UTF-8'),
        'puntuacion' => $a->puntuacion
    ];
}

function sanitizeValoracionConNombre($a) {
    return [
        'id' => $a->id,
        'id_anuncio' => $a->id_anuncio,
        'nombre_autor' => mb_convert_encoding($a->id_usuario, 'UTF-8', 'UTF-8'),
        'texto' => mb_convert_encoding($a->texto, 'UTF-8', 'UTF-8'),
        'puntuacion' => $a->puntuacion
    ];
}

class ValoracionController extends Controller{

    public function get($id){
        $model = new ValoracionModel();
        $valoracion = $model->get($id);

        if($valoracion==null){
            Controller::sendNotFound("El id no se corresponde con ninguna valoracion");
            die();
        }

        echo json_encode(sanitizeValoracion($valoracion),JSON_PRETTY_PRINT);
    }   

    public function getAll() {
        $model = new ValoracionModel();
        $valoraciones = $model->getAll();

        $valoraciones_array = [];

        foreach ($valoraciones as $a) {
            $valoraciones_array[] = sanitizeValoracion($a);
        }
    
        echo json_encode($valoraciones_array, JSON_PRETTY_PRINT);
    }

    public function getByAnuncio($id){
        $model = new ValoracionModel();
        $valoraciones = $model->getByAnuncio($id);

        $valoraciones_array = [];

        foreach ($valoraciones as $a) {
            $valoraciones_array[] = sanitizeValoracionConNombre($a);
        }
    
        echo json_encode($valoraciones_array, JSON_PRETTY_PRINT);
    }

    public function getByAutor($id){
        $model = new ValoracionModel();
        $valoraciones = $model->getByAutor($id);
        $valoraciones_array = [];

        foreach ($valoraciones as $a) {
            $valoraciones_array[] = sanitizeValoracionConNombre($a);
        }
    
        echo json_encode($valoraciones_array, JSON_PRETTY_PRINT);
    }

    public function insert($object){
        $model = new ValoracionModel();
        $valoracion = Valoracion::fromJson($object);
        if($model->insert($valoracion)){
            echo json_encode(["msg" => "Valoración insertada."],JSON_PRETTY_PRINT);
        }else{
            Controller::sendNotFound("No se ha podido insertar");
        }

    }
    
    public function delete($id) {
        $model = new ValoracionModel();
        if($model->delete($id[0])){
            echo json_encode(["msg" => "Valoración eliminada."],JSON_PRETTY_PRINT);
        }else{
            Controller::sendNotFound("No se ha podido eliminar");
        }
    }

    public function update($id, $object){
        $model = new ValoracionModel();
        $valoracion = Valoracion::fromJson($object);

        if($model->update($valoracion,$id[0])){
            echo json_encode(["msg" => "Valoración modificada."],JSON_PRETTY_PRINT);
        }else{
            Controller::sendNotFound("No se ha podido modificar");
        }
    }
}