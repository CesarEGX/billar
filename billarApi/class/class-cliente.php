<?php
class Cliente{

    public function eliminarCliente(){
        include_once '../database/conexion.php';
        //traiada de datos
        $id_cliente = $_POST['id_cliente'];

        $response = array();
        $response['succes'] = false;

        //verificar si id_cliente esta en reserva
        $sql = "SELECT id_clienteLF, COUNT(*) cantidad FROM reserva WHERE id_clienteLF = '$id_cliente'";
        $result = mysqli_query($conexion,$sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            //si se tiene id_cliente en reservas mandar error de eliminacion
            if($row['cantidad'] > 0){
                $response['succes'] = "errorReserva";
                die(json_encode($response));
                exit();
            }else{
                //continuar eliminando
            }
            
        } else {
            //error
        }
        //-------------------------------------------------
        //sacar el id_persona
        //consulta
        $sql = "SELECT id_personaLF FROM cliente WHERE id_cliente = '$id_cliente'";

        $resultado = $conexion -> query($sql);
        if($resultado -> num_rows > 0){
            while($dataCliente = $resultado -> fetch_assoc()){
                $id_persona = $dataCliente['id_personaLF'];
            }
        }

        //eliminar tabla cliente
        $sql = "DELETE FROM cliente WHERE id_cliente = '$id_cliente'";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }else{
            $response['succes'] = false;
        }

        //eliminar tabla persona
        $sql = "DELETE FROM persona WHERE id_persona = '$id_persona'";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }else{
            $response['succes'] = false;
        }

        
        die(json_encode($response)); 
    }

    public function AgregarCliente(){
        include_once '../database/conexion.php';

        $ci = $_POST['ci'];
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $edad = $_POST['edad'];

        $response = array();
        $response['succes'] = false;

        // Verificar si el CI ya está registrado
        $queryCi = "SELECT COUNT(*) AS count FROM persona WHERE ci = '$ci'";
        $resultCi = mysqli_query($conexion, $queryCi);

        $rowCi = mysqli_fetch_assoc($resultCi);
        $countCi = $rowCi['count'];

        // Verificar si el email ya está registrado
        $queryEmail = "SELECT COUNT(*) AS count FROM persona WHERE correo = '$correo'";
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
            $sql = "INSERT INTO persona values(null,'$ci','$nombre','$apellido_paterno','$apellido_materno','$correo','$telefono','$edad') ";
            $resultado = mysqli_query($conexion,$sql);
            $ultimo_id = mysqli_insert_id($conexion);
            if($resultado){
                //insertar en la tabla empleado
                $sql = "INSERT INTO cliente values(null,'$ultimo_id')";
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

    public function editarCliente(){
        include_once '../database/conexion.php';

        $id_cliente = $_POST['id_cliente'];
        $ci = $_POST['ci'];
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $edad = $_POST['edad'];

        $response = array();
        $response['succes'] = false;

        //sacar el id_persona de empleado
        $sql = "SELECT id_personaLF FROM cliente WHERE id_cliente = '$id_cliente'";
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
                $response['succes'] = true;
            }
            else{
                $response['succes'] = false;
            }
        }
        die(json_encode($response));

    }


}


?>