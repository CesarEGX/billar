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
$query = "SELECT cliente.id_cliente,persona.ci,persona.nombre,persona.apellido_paterno,persona.apellido_materno,persona.correo,persona.telefono
    FROM persona
    INNER JOIN  cliente ON persona.id_persona = cliente.id_personaLF  ORDER BY cliente.id_cliente DESC";

$result = $conexion->query($query);

$clientes = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cliente = array(
            'id_cliente' => $row['id_cliente'],
            'ci' => $row['ci'],
            'nombre' => $row['nombre'],
            'apellido_paterno' => $row['apellido_paterno'],
            'apellido_materno' => $row['apellido_materno'],
            'correo' => $row['correo'],
            'telefono' => $row['telefono'],
        );
        $clientes[] = $cliente;
    }
}

// Cerrar la conexión a la base de datos
//$conexion->close();

// Devolver los usuarios en formato JSON
header('Content-Type: application/json');
echo json_encode($clientes);
?>
