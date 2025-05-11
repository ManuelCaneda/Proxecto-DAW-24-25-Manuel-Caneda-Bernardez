<?php

class View {
    public static function show($vista,$data=null){
        include($vista.'-view.php');
    }
}