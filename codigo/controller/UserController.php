<?php
require_once("globals.php");
require_once(VIEW_PATH."View.php");
require_once(MODEL_PATH."UsuarioModel.php");

class UserController {

    public function login(){
        return View::show("login");
    }

    public function checkLogin(){
        $email = $_POST['email']??null;
        $pass = $_POST['pass']??null;

        
        if(isset($email) && isset($pass)){
            $model = new UsuarioModel();

            $user = $model->get($email,$pass);

            if($user!=null){
                session_start();
                $_SESSION['logged'] = $user->getId();
                header("Location: ?controller=page&action=main");
            } else {
                return View::show("login",['error' => true]);
            }
        }
    }

    public function registrar(){
        return View::show("register");
    }

    public function checkRegistro(){
        $data = [];

        $nombre = $_POST['nombre']??null;
        $aps = $_POST['aps']??null;
        $email = $_POST['email']??null;
        $pass1 = $_POST['pass1']??null;
        $pass2 = $_POST['pass2']??null;

        if(isset($nombre) && isset($aps) && isset($email) && isset($pass1) && isset($pass2)){
            if($pass1 == $pass2){
                $user = new Usuario($nombre,$aps,$email,$pass1);
                $model = new UsuarioModel();
                
                if($model->add($user)){
                    $vista = "login";
                    $data['registered'] = true;
                } else {
                    $vista = "register";
                    $data['registered'] = false;
                }
            } else {
                $vista = "register";
                $data['confirm_pass'] = false;
            }

            return View::show($vista,$data);
        }
    }

    public function editarPerfil(){
        return View::show("editar-perfil");
    }

    
    public function chat(){
        return View::show("chat");
    }
}