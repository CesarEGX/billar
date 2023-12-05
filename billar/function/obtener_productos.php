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
$query = "SELECT pr.*, ma.nombre AS nombre_marca, tp.descripcion AS nombre_categoria  
    FROM producto pr 
    INNER JOIN marca ma ON pr.id_marcaLF = ma.id_marca
    INNER JOIN tipo_producto tp  ON pr.id_tipo_productoLF = tp.id_tipo_producto
    ORDER BY pr.id_producto DESC
";

$result = $conexion->query($query);

$productos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $producto = array(
            'id_producto' => $row['id_producto'],
            'nombre' => $row['nombre'],
            'nombre_marca' => $row['nombre_marca'],
            'nombre_categoria' => $row['nombre_categoria'],
            'stock' => $row['stock'],
        );
        $productos[] = $producto;
    }
}


// Devolver los usuarios en formato JSON
header('Content-Type: application/json');
echo json_encode($productos);
?>
