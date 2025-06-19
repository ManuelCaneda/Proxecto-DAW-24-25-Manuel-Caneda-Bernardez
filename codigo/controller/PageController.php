<?php
require_once("globals.php");
require_once(VIEW_PATH."View.php");
class PageController {
    public function land_page(){
        return View::show("landpage");
    }

    public function main(){
        return View::show("main");
    }

    public function verAnuncio($idAnuncio){
        $data["id_anuncio"] = $idAnuncio;
        
        return View::show("ver-anuncio",$data);
    }

    public function crearAnuncio() {
        return View::show("crear-anuncio");
    }

    public function editarAnuncio($idAnuncio) {
        $data["id_anuncio"] = $idAnuncio;
        return View::show("editar-anuncio",$data);
    }

    public function avisoLegal(){
        return View::show("aviso-legal");
    }

    public function rgpd(){
        return View::show("rgpd");
    }

    public function notFound(){
        return View::show("404");
    }
}