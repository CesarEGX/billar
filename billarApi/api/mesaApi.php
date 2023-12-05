<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../class/class-mesa.php");
//Recibir peticiones del usuario
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $mesa = new Mesa();
        $mesa->AgregarMesa();
        
    break;    
    case 'DELETE':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $mesa = new Mesa($_POST["id_mesa"]);
        $mesa->eliminarMesa();
        
    break;    
    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $empleado = new Empleado($_POST['id_empleado'],$_POST["ci"],$_POST['nombre'],$_POST['apellido_paterno'],$_POST['apellido_materno'],$_POST['email'],$_POST['contrasena'],$_POST['telefono'],$_POST['edad'],$_POST['id_tipoEmpleadoLF']);
        $empleado->editarEmpleado();
        
    break;    
        

}

?>