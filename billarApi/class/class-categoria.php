<?php
class Categoria{

    public function AgregarCategoria(){
        include_once '../database/conexion.php';
        $descripcion = $_POST['descripcion'];

        $response = array();
        $response['succes'] = false;

        $sql = "INSERT INTO tipo_producto values(null,'$descripcion')";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }
        else{
            $response['succes'] = false;
        }  
        die(json_encode($response));
    }

    public function eliminarCategoria(){
        include_once '../database/conexion.php';
        $id_tipo_producto = $_POST['id_categoria'];

        $response = array();
        $response['succes'] = false;

        //verificar si id_producto tiene ventas
        $sql = "SELECT id_tipo_productoLF, COUNT(*) cantidad FROM producto WHERE id_tipo_productoLF = '$id_tipo_producto'";
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
                $sql = "DELETE FROM tipo_producto WHERE id_tipo_producto = '$id_tipo_producto'";
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

    public function editarCategoria(){
        include_once '../database/conexion.php';
        $id_tipo_producto = $_POST['id_categoria'];
        $descripcion = $_POST['descripcion'];

        $response = array();
        $response['succes'] = false;

        $sql = "UPDATE tipo_producto SET descripcion = '$descripcion' WHERE id_tipo_producto = '$id_tipo_producto'";
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