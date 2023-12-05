<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../class/class-login.php");
//Recibir peticiones del usuario
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $login = new Login($_POST["correo"],$_POST['contrasena']);
        $login->loguear();
        
    break;    
        

}

?>