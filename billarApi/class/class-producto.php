<?php
class Producto{

    public function AgregarProducto(){
        include_once '../database/conexion.php';

        $nombre_producto = $_POST['nombre_producto'];
        $id_tipo_producto = $_POST['id_tipo_producto'];
        $id_marca = $_POST['id_marca'];
        $stock = $_POST['stock'];   

        $response = array();
        $response['succes'] = false;

        $sql = "INSERT INTO producto values(null,'$nombre_producto','$stock','$id_tipo_producto','$id_marca')";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }else{
            $response['succes'] = false;
        }

        die(json_encode($response));

    }

    public function EliminarProducto(){
        include_once '../database/conexion.php';
        $id_producto = $_POST['id_producto'];

        $response = array();
        $response['succes'] = false;

        //verificar si id_producto tiene ventas
        $sql = "SELECT id_productoLF, COUNT(*) cantidad FROM anadir_consumo WHERE id_productoLF = '$id_producto'";
        $result = mysqli_query($conexion,$sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            //si se tiene id_producto en reservas mandar error de eliminacion
            if($row['cantidad'] > 0){
                $response['succes'] = "errorVenta";
                die(json_encode($response));
                exit();
            }else{
                //continuar eliminando
                $sql = "DELETE FROM producto WHERE id_producto = '$id_producto'";
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

    public function editarProducto(){
        include_once '../database/conexion.php';

        $id_producto = $_POST['id_producto'];
        $nombre_producto = $_POST['nombre_producto'];
        $id_tipo_producto = $_POST['id_tipo_producto'];
        $id_marca = $_POST['id_marca'];
        $stock = $_POST['stock'];   

        $response = array();
        $response['succes'] = false;

        $sql = "UPDATE producto SET nombre = '$nombre_producto',stock = '$stock', id_tipo_productoLF = '$id_tipo_producto', id_marcaLF = '$id_marca' WHERE id_producto = '$id_producto'";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }else{
            $response['succes'] = false;
        }
        die(json_encode($response));


    }



}





?>