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

    public function verAnuncio(){
        return View::show("ver-anuncio");
    }

    public function crearAnuncio() {
        return View::show("crear-anuncio");
    }

    public function editarAnuncio() {
        return View::show("editar-anuncio");
    }

    public function avisoLegal(){
        return View::show("aviso-legal");
    }

    public function rgpd(){
        return View::show("rgpd");
    }
}