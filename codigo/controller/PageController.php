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
}