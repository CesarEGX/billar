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
$query = "SELECT * FROM mesa";

$result = $conexion->query($query);

$mesas = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mesa = array(
            'id_mesa' => $row['id_mesa'],
            'numero_mesa' => $row['numero_mesa'],
            'estado' => $row['estado'],
        );
        $mesas[] = $mesa;
    }
}


// Devolver los usuarios en formato JSON
header('Content-Type: application/json');
echo json_encode($mesas);
?>
