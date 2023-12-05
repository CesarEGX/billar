<?php

class Reserva{

    private $conexion;

    public function __construct() {
        include_once '../database/conexion.php';
        $this->conexion = $conexion;
    }

    public function eliminarReserva(){
        
        $id_reserva = $_POST['id_reserva'];
        $response = array();
        $response['succes'] = false;

        $sql = "UPDATE reserva SET estado = 0 WHERE id_reserva = '$id_reserva'";
        $resultado = mysqli_query($this->conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }   
        die(json_encode($response));
        

    }

    public function AgregarReserva(){
        
        $id_cliente = $_POST['id_cliente'];
        $id_mesa = $_POST['id_mesa'];
        $fecha_solicitud = $_POST['fecha_solicitud'];
        $fecha_alquiler = $_POST['fecha_alquiler'];
        $hora_start = $_POST['hora_start'];
        $hora_stop = $_POST['hora_stop'];
        $id_empleado = $_POST['id_empleado'];

        $response = array();
        $response['succes'] = false;

        // Protección contra inyecciones SQL
        $fecha_alquiler = mysqli_real_escape_string($this->conexion, $fecha_alquiler);
        $id_mesa = mysqli_real_escape_string($this->conexion, $id_mesa);
        $hora_start = mysqli_real_escape_string($this->conexion, $hora_start);
        $hora_stop = mysqli_real_escape_string($this->conexion, $hora_stop);

        $sql = "SELECT detalle_mesa.* FROM detalle_mesa
                JOIN reserva ON detalle_mesa.id_reservaLF = reserva.id_reserva
                WHERE reserva.fecha_alquiler = '$fecha_alquiler' AND detalle_mesa.id_mesaLF = '$id_mesa' 
                AND (detalle_mesa.hora_start <= '$hora_stop' AND detalle_mesa.hora_stop >= '$hora_start') 
                AND reserva.estado = 1";

        $resultado = mysqli_query($this->conexion,$sql);

        // Verifica si la consulta se ejecutó con éxito
        if ($resultado) {
            if (mysqli_num_rows($resultado) > 0) {
                //La reserva no se puede hacer. Ya existe una reserva con la misma fecha, mesa, y rango de tiempo.";
                $response['succes'] = "errorSolapamiento";
                die(json_encode($response));
                exit();
            } else {
                // Aquí puedes agregar el código para realizar la nueva reserva
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->conexion);
        }


        //---------------------------------------------------------------------------------------------------------------------
        $sql = "INSERT INTO reserva Values(null,'$fecha_solicitud','$fecha_alquiler',1,'$id_cliente','$id_empleado')";
        $resultado = mysqli_query($this->conexion,$sql);
        $id_reserva_ultimo = mysqli_insert_id($this->conexion);

        if($resultado){
            $sql = "INSERT INTO detalle_mesa values(null,'$id_mesa','$id_reserva_ultimo','$fecha_alquiler','$hora_start','$hora_stop')";
            $resultado2 = mysqli_query($this->conexion,$sql);
            if($resultado2){
                $response['succes'] = true;
            }else{
                $response['succes'] = false;
            }
        }else{
            $response['succes'] = false;
        }
        die(json_encode($response));
    }

    public function completarReserva(){
        
        $id_reserva = $_POST['id_reserva'];

        //consultar estado
        $sql = "SELECT estado FROM reserva WHERE id_reserva = '$id_reserva'";
        $resultado = mysqli_query($this->conexion,$sql);
        if($resultado) {
            if($resultado -> num_rows > 0) {
                $row = mysqli_fetch_assoc($resultado);
                $estado = $row["estado"];
            } else {
                echo "No se encontraron resultados para el id_reserva: " . $id_reserva;
            }
        } else {
            echo "Hubo un error ejecutando la consulta: " . mysqli_error($this->conexion);
        }
        
        if($estado == 1){
            $this->enProcesoReserva($id_reserva);
        }else{
            $sql = "UPDATE reserva SET estado = 3 WHERE id_reserva = '$id_reserva'";
            $resultado = mysqli_query($this->conexion,$sql);
            
            if($resultado){
                $response['succes'] = true;
            }else{
                $response['succes'] = false;
            }
            die(json_encode($response));
        }
    }
    public function enProcesoReserva($id_reserva){
        
        $sql = "UPDATE reserva SET estado = 2 WHERE id_reserva = '$id_reserva'";
        $resultado = mysqli_query($this->conexion,$sql);
        
        if($resultado){
            $response['succes'] = true;
        }else{
            $response['succes'] = false;
        }

        die(json_encode($response));
    }


    public function editarReserva(){
        
        $id_reserva = $_POST['id_reserva'];
        $id_cliente = $_POST['id_cliente'];
        $id_mesa = $_POST['id_mesa'];
        $fecha_solicitud = $_POST['fecha_solicitud'];
        $fecha_alquiler = $_POST['fecha_alquiler'];
        $hora_start = $_POST['hora_start'];
        $hora_stop = $_POST['hora_stop'];

        $response = array();
        $response['succes'] = false;

        $id_reserva = $_POST['id_reserva'];

        // Protección contra inyecciones SQL
        $id_reserva = mysqli_real_escape_string($this->conexion, $id_reserva);
        $fecha_alquiler = mysqli_real_escape_string($this->conexion, $fecha_alquiler);
        $id_mesa = mysqli_real_escape_string($this->conexion, $id_mesa);
        $hora_start = mysqli_real_escape_string($this->conexion, $hora_start);
        $hora_stop = mysqli_real_escape_string($this->conexion, $hora_stop);

        $sql = "SELECT detalle_mesa.* FROM detalle_mesa
                JOIN reserva ON detalle_mesa.id_reservaLF = reserva.id_reserva
                WHERE reserva.id_reserva != '$id_reserva' AND reserva.fecha_alquiler = '$fecha_alquiler' 
                AND detalle_mesa.id_mesaLF = '$id_mesa' 
                AND (detalle_mesa.hora_start <= '$hora_stop' AND detalle_mesa.hora_stop >= '$hora_start') 
                AND reserva.estado = 1";

        $resultado = mysqli_query($this->conexion,$sql);

        // Verifica si la consulta se ejecutó con éxito
        if ($resultado) {
            if (mysqli_num_rows($resultado) > 0) {
                //echo "La reserva no se puede hacer. Ya existe una reserva con la misma fecha, mesa, y rango de tiempo.";
                $response['succes'] = 'errorSolapamiento';
                die(json_encode($response));
                exit();
            } else {
                $sql = "UPDATE detalle_mesa SET id_mesaLF = '$id_mesa', fecha_reserva = '$fecha_alquiler', hora_start = '$hora_start', hora_stop = '$hora_stop' WHERE id_reservaLF = '$id_reserva'";
                $resultado = mysqli_query($this->conexion,$sql);
                if($resultado){
                    $sql = "UPDATE reserva SET fecha_solicitud = '$fecha_solicitud', fecha_alquiler = '$fecha_alquiler', id_clienteLF = '$id_cliente' WHERE id_reserva = '$id_reserva'";
                    $resultado2 = mysqli_query($this->conexion,$sql);
                    if($resultado2){
                        $response['succes'] = true;
                    }else{
                        echo "error en la base de datos";
                    }
                }else{
                    echo "error en la base de datos";
                }

            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->conexion);
        }

        die(json_encode($response));
    }

   


}







?>