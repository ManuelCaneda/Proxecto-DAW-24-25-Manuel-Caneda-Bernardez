<?php
include_once("Controller.php");
include_once(PATH_MODEL."AnuncioModel.php");

//die(PATH_MODEL."AnuncioModel.php");   

function sanitizeAnuncio($a) {
    return [
        'id_anuncio' => $a->id_anuncio,
        'id_cliente' => $a->id_cliente,
        'imagen' => mb_convert_encoding($a->imagen, 'UTF-8', 'UTF-8'),
        'nombre' => mb_convert_encoding($a->nombre, 'UTF-8', 'UTF-8'),
        'texto' => mb_convert_encoding($a->texto, 'UTF-8', 'UTF-8'),
        'precio' => $a->precio,
        'estado' => mb_convert_encoding($a->estado, 'UTF-8', 'UTF-8')
    ];
} 

class AnuncioController extends Controller{

    public function get($id){
        $model = new AnuncioModel();
        $anuncio = $model->get($id);

        if($anuncio==null){
            Controller::sendNotFound("El id no se corresponde con ningún anuncio");
            die();
        }

        echo json_encode(sanitizeAnuncio($anuncio),JSON_PRETTY_PRINT);
    }   

    public function getAll() {
        $model = new AnuncioModel();
        $anuncios = $model->getAll();

        $anuncios_array = [];

        foreach ($anuncios as $a) {
            $anuncios_array[] = sanitizeAnuncio($a);
        }
    
        echo json_encode($anuncios_array, JSON_PRETTY_PRINT);
    }

    public function insert($object){
        $model = new AnuncioModel();
        $anuncio = Anuncio::fromJson($object);
        if($model->insert($anuncio)){
            echo "Anuncio insertado.";
        }else{
            Controller::sendNotFound("No se ha podido insertar");
        }

    }
    
    public function delete($id) {
        $model = new AnuncioModel();
        if($model->delete($id[0],$id[1])){
            echo "Anuncio eliminado.";
        }else{
            Controller::sendNotFound("No se ha podido eliminar");
        }
    }

    public function update($id, $object){
        $model = new AnuncioModel();
        $anuncio = Anuncio::fromJson($object);

        if($model->update($anuncio,$id[0])){
            echo "Anuncio modificado.";
        }else{
            Controller::sendNotFound("No se ha podido modificar");
        }
    }
}