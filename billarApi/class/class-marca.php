<?php
class Marca{

    public function AgregarMarca(){
        include_once '../database/conexion.php';
        $nombre = $_POST['nombre_marca'];

        $response = array();
        $response['succes'] = false;

        $sql = "INSERT INTO marca values(null,'$nombre')";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }
        else{
            $response['succes'] = false;
        }  
        die(json_encode($response));
    }


    public function eliminarMarca(){
        include_once '../database/conexion.php';
        $id_marca = $_POST['id_marca'];

        $response = array();
        $response['succes'] = false;

        //verificar si id_producto tiene ventas
        $sql = "SELECT id_marcaLF, COUNT(*) cantidad FROM producto WHERE id_marcaLF = '$id_marca'";
        $result = mysqli_query($conexion,$sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            //si se tiene id_producto en reservas mandar error de eliminacion
            if($row['cantidad'] > 0){
                $response['succes'] = "errorRegistro";
                die(json_encode($response));
                exit();
            }else{
                //continuar eliminando
                $sql = "DELETE FROM marca WHERE id_marca = '$id_marca'";
                $resultado = mysqli_query($conexion,$sql);
                if($resultado){
                    $response['succes'] = true;
                }else{
                    $response['succes'] = false;
                }
            }
            
        } else {
            //error base de datos
            $response['succes'] = false;
        }
        die(json_encode($response));
    }

    public function editarMarca(){
        include_once '../database/conexion.php';
        $id_marca = $_POST['id_marca'];
        $nombre = $_POST['nombre_marca'];

        $response = array();
        $response['succes'] = false;

        $sql = "UPDATE marca SET nombre = '$nombre' WHERE id_marca = '$id_marca'";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }
        else{
            $response['succes'] = false;
        }  
        die(json_encode($response));
    }

}






?>