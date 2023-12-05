<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../class/class-cliente.php");
//Recibir peticiones del usuario
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $cliente = new Cliente($_POST["ci"],$_POST['nombre'],$_POST['apellido_paterno'],$_POST['apellido_materno'],$_POST['correo'],$_POST['telefono'],$_POST['edad']);
        $cliente->AgregarCliente();
        
    break;    
    case 'DELETE':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $cliente = new Cliente($_POST["id_cliente"]);
        $cliente->eliminarCliente();
        
    break;   
    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $cliente = new Cliente($_POST['id_cliente'],$_POST["ci"],$_POST['nombre'],$_POST['apellido_paterno'],$_POST['apellido_materno'],$_POST['correo'],$_POST['telefono'],$_POST['edad']);
        $cliente->editarCliente();
        
    break;    
        

}

?>