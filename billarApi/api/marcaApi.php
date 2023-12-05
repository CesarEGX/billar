<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../class/class-marca.php");
//Recibir peticiones del usuario
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $marca = new Marca($_POST['nombre_marca']);
        $marca->AgregarMarca();
        
    break;    
    case 'DELETE':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $mesa = new Marca($_POST["id_marca"]);
        $mesa->eliminarMarca();
        
    break;    
    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $mesa = new Marca($_POST['id_marca'],$_POST["nombre_marca"]);
        $mesa->editarMarca();
        
    break;    
        

}

?>