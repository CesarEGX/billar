<?php
// Conexión a la base de datospersona
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "billar";
$conexion= new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener los usuarios con su tipo de empleado
$query = "SELECT * FROM tipo_producto order by id_tipo_producto DESC";

$result = $conexion->query($query);

$categorias = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categoria = array(
            'id_tipo_producto' => $row['id_tipo_producto'],
            'descripcion' => $row['descripcion']
        );
        $categorias[] = $categoria;
    }
}


// Devolver los usuarios en formato JSON
header('Content-Type: application/json');
echo json_encode($categorias);
?>
