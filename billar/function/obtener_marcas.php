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
$query = "SELECT * FROM marca order by id_marca DESC";

$result = $conexion->query($query);

$marcas = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $marca = array(
            'id_marca' => $row['id_marca'],
            'nombre' => $row['nombre']
        );
        $marcas[] = $marca;
    }
}


// Devolver los usuarios en formato JSON
header('Content-Type: application/json');
echo json_encode($marcas);
?>
