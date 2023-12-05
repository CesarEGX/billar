<?php
class Mesa{

public function eliminarMesa(){
    include_once '../database/conexion.php';
    $id_mesa = $_POST['id_mesa'];

    $response = array();
    $response['succes'] = false;

    //consulta
    $sql = "SELECT estado FROM mesa WHERE id_mesa = '$id_mesa'";
    $resultado = $conexion -> query($sql);
    if($resultado -> num_rows > 0){
        while($dataMesa = $resultado -> fetch_assoc()){
            $estado = $dataMesa['estado'];
        }
    }

    if($estado == 0){
        $sql = "UPDATE mesa SET estado = 1 WHERE id_mesa = $id_mesa";
        $resultado = mysqli_query($conexion,$sql);
        if($resultado){
            $response['succes'] = true;
        }
        else{
            $response['succes'] = false;
        }

    }else if($estado == 1){
        $sql = "UPDATE mesa SET estado = 0 WHERE id_mesa = $id_mesa";
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


public function AgregarMesa(){
    include_once '../database/conexion.php';
    //consultar nro de mesa:
    $sql = "SELECT numero_mesa FROM mesa ORDER BY id_mesa DESC LIMIT 1";
    $resultado = $conexion -> query($sql);
        if($resultado -> num_rows > 0){
            while($dataUsuario = $resultado -> fetch_assoc()){
                $numero_mesa = $dataUsuario['numero_mesa'];
            }
        }
    $num_mesa = $numero_mesa + 1;

    //insertar datos
    $sql2 = "INSERT INTO mesa values(null,'$num_mesa',1)";
    $resultado = mysqli_query($conexion,$sql2);



}


}







?>