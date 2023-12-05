<?php

class Login{

    public  function loguear(){
        include_once '../database/conexion.php';
        session_start(); 

        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];

        $response = array();
        $response['succes'] = false;

        //utilizamos consultas preparas para no ser vulnerable a inyeccion sql
        $consulta = "SELECT * FROM empleado WHERE correo = ? AND contrasena = ? AND estado = 1 ";
        $statement = $conexion->prepare($consulta);
        $statement->bind_param("ss", $correo, $contrasena);
        $statement->execute();
        $resultado = $statement->get_result();

        if ($resultado->num_rows > 0) {
            $empleado = mysqli_fetch_assoc($resultado);
            $_SESSION["id_empleado"] = $empleado["id_empleado"];
            $response['succes'] = true;
            die(json_encode($response));
            
        } else {
            $response['succes'] = false;
            die(json_encode($response));
        }

        $statement->close();

    } 



}


?>