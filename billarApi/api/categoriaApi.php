<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../class/class-categoria.php");
//Recibir peticiones del usuario
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $categoria = new Categoria($_POST['descripcion']);
        $categoria->AgregarCategoria();
        
    break;    
    case 'DELETE':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $categoria = new Categoria($_POST["id_categoria"]);
        $categoria->eliminarCategoria();
        
    break;    
    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $categoria = new Categoria($_POST['id_categoria'],$_POST["descripcion"]);
        $categoria->editarCategoria();
        
    break;    
        

}

?>