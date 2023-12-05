<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../class/class-reserva.php");
//Recibir peticiones del usuario
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $reserva = new Reserva($_POST["id_cliente"],$_POST['id_mesa'],$_POST['fecha_solicitud'],$_POST['fecha_alquiler'],$_POST['hora_start'],$_POST['hora_stop'],$_POST['id_empleado']);
        $reserva->AgregarReserva();
        
    break;    
    case 'DELETE':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $reserva = new Reserva($_POST["id_reserva"]);
        $reserva->eliminarReserva();
        
    break;    
    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $reserva = new Reserva($_POST["id_reserva"],$_POST["id_cliente"],$_POST['id_mesa'],$_POST['fecha_solicitud'],$_POST['fecha_alquiler'],$_POST['hora_start'],$_POST['hora_stop']);
        $reserva->editarReserva();
        
    break;
    case 'PATCH':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $reserva = new Reserva($_POST["id_reserva"]);
        $reserva->completarReserva();
        
    break;

        

}

?>