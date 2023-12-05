<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../class/class-producto.php");
//Recibir peticiones del usuario
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $producto = new Producto($_POST['nombre_producto'],$_POST['id_marca'],$_POST['id_tipo_producto'],$_POST['stock']);
        $producto->AgregarProducto();
        
    break;    
    case 'DELETE':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $producto = new Producto($_POST["id_producto"]);
        $producto->eliminarProducto();
        
    break;    
    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $producto = new Producto($_POST['id_producto'],$_POST['nombre_producto'],$_POST['id_marca'],$_POST['id_tipo_producto'],$_POST['stock']);
        $producto->editarProducto();
        
    break;    
        

}

?>