<?php

class Empleado{

    public function eliminarEmpleado(){
        include_once '../database/conexion.php';

        $id_empleado = $_POST['id_empleado'];

        $response = array();
        $response['succes'] = false;

        //consulta
        $sql = "SELECT estado FROM empleado WHERE id_empleado = '$id_empleado'";
        $resultado = $conexion -> query($sql);
        if($resultado -> num_rows > 0){
            while($dataUsuario = $resultado -> fetch_assoc()){
                $estado = $dataUsuario['estado'];
            }
        }

        if($estado == 0){
            $sql = "UPDATE empleado SET estado = 1 WHERE id_empleado = $id_empleado";
            $resultado = mysqli_query($conexion,$sql);
            if($resultado){
                $response['succes'] = true;
            }
            else{
                $response['succes'] = false;
            }

        }else if($estado == 1){
            $sql = "UPDATE empleado SET estado = 0 WHERE id_empleado = $id_empleado";
            $resultado = mysqli_query($conexion,$sql);
            if($resultado){
                $response['succes'] = true;
            }
            else{
                $response['succes'] = false;
            }
        }
        die(json_encode($response));
        



    }

    public function AgregarEmpleado(){
        include_once '../database/conexion.php';

        $ci = $_POST['ci'];
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $correo = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $telefono = $_POST['telefono'];
        $edad = $_POST['edad'];
        $id_tipoEmpleadoLF = $_POST['id_tipoEmpleadoLF'];
        $estado = 1;

        $response = array();
        $response['succes'] = false;

        // Verificar si el CI ya está registrado
        $queryCi = "SELECT COUNT(*) AS count FROM empleado WHERE ci = '$ci'";
        $resultCi = mysqli_query($conexion, $queryCi);

        $rowCi = mysqli_fetch_assoc($resultCi);
        $countCi = $rowCi['count'];

        // Verificar si el email ya está registrado
        $queryEmail = "SELECT COUNT(*) AS count FROM empleado WHERE correo = '$correo'";
        $resultEmail = mysqli_query($conexion, $queryEmail);

        $rowEmail = mysqli_fetch_assoc($resultEmail);
        $countEmail = $rowEmail['count'];

        if($countCi > 0 && $countEmail == 0){
            $response['succes'] = "errorCi";
        }else if($countCi == 0 && $countEmail > 0){
            $response['succes'] = "errorEmail";
        }else if($countCi > 0 && $countEmail > 0){
            $response['succes'] = "errorCi&Email";
        }else if($countCi == 0 && $countEmail == 0){
            $sql = "INSERT INTO persona values(null,'$ci','$nombre','$apellido_paterno','$apellido_materno','$correo','$telefono','$edad') ";
            $resultado = mysqli_query($conexion,$sql);
            $ultimo_id = mysqli_insert_id($conexion);
            if($resultado){
                //insertar en la tabla empleado
                $sql = "INSERT INTO empleado values(null,'$ci','$correo','$contrasena',1,'$ultimo_id','$id_tipoEmpleadoLF')";
                $resultado = mysqli_query($conexion,$sql);
                if($resultado){
                    $response['succes'] = true;
                }else{
                    $response['succes'] = false;
                }
            }
            else{
                $response['succes'] = false;
            }
        }
        die(json_encode($response));
    
    }

    public function editarEmpleado(){
        include_once '../database/conexion.php';

        $id_empleado = $_POST['id_empleado'];
        $ci = $_POST['ci'];
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $correo = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $telefono = $_POST['telefono'];
        $edad = $_POST['edad'];
        $id_tipoEmpleadoLF = $_POST['id_tipoEmpleadoLF'];

        $response = array();
        $response['succes'] = false;

        //sacar el id_persona de empleado
        $sql = "SELECT id_personaLF FROM empleado WHERE id_empleado = '$id_empleado'";
        $resultado = $conexion->query($sql);
        if ($resultado === false) {
            $response['succes'] = 'error SQL: '.$conexion->error;
            die(json_encode($response));
            exit();
        } else {
            if ($resultado->num_rows > 0) {
                while ($dataEmpleado = $resultado->fetch_assoc()) {
                    $id_persona = $dataEmpleado['id_personaLF'];
                }
            } else {
                $response['succes'] = 'No se encontraron registros del id:'.$id_empleado;
                die(json_encode($response));
                exit();
            }
        }



        // Verificar si el CI ya está registrado, excluyendo el empleado actual
        $queryCi = "SELECT COUNT(*) AS count FROM persona WHERE ci = '$ci' AND id_persona != '$id_persona'";
        $resultCi = mysqli_query($conexion, $queryCi);

        $rowCi = mysqli_fetch_assoc($resultCi);
        $countCi = $rowCi['count'];

        // Verificar si el email ya está registrado, excluyendo al empleado actual
        $queryEmail = "SELECT COUNT(*) AS count FROM persona WHERE correo = '$correo' AND id_persona != '$id_persona'";
        $resultEmail = mysqli_query($conexion, $queryEmail);

        $rowEmail = mysqli_fetch_assoc($resultEmail);
        $countEmail = $rowEmail['count'];

        if($countCi > 0 && $countEmail == 0){
            $response['succes'] = "errorCi";
        }else if($countCi == 0 && $countEmail > 0){
            $response['succes'] = "errorEmail";
        }else if($countCi > 0 && $countEmail > 0){
            $response['succes'] = "errorCi&Email";
        }else if($countCi == 0 && $countEmail == 0){
            //insertar tabla persona
            $sql = "UPDATE persona SET ci = '$ci', nombre = '$nombre', apellido_paterno = '$apellido_paterno',apellido_materno = '$apellido_materno',correo = '$correo', telefono = '$telefono', edad = '$edad' WHERE id_persona = '$id_persona'";
            $resultado = mysqli_query($conexion,$sql);
            if($resultado){
                //insertamos datos en la tabla empleado
                $sql = "UPDATE empleado SET ci = '$ci',correo = '$correo', contrasena = '$contrasena',id_tipo_empleadoLF = '$id_tipoEmpleadoLF' WHERE id_empleado = '$id_empleado'";
                $resultado = mysqli_query($conexion,$sql);
                if($resultado){
                    $response['succes'] = true;
                }else{
                    $response['succes'] = false; 
                }
            }
            else{
                $response['succes'] = false;
            }
        }
        die(json_encode($response));
    }


}






?>


