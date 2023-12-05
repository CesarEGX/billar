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
$query = "SELECT re.*, de.id_detalle_mesa, de.id_mesaLF, de.id_reservaLF, de.fecha_reserva, de.hora_start, de.hora_stop, pe.nombre, pe.apellido_paterno, me.numero_mesa
    FROM reserva re
    INNER JOIN detalle_mesa de ON re.id_reserva = de.id_reservaLF
    INNER JOIN cliente cl ON re.id_clienteLF = cl.id_cliente
    INNER JOIN persona pe ON cl.id_personaLF = pe.id_persona
    INNER JOIN mesa me ON me.id_mesa = de.id_mesaLF
    ORDER BY re.id_reserva DESC
";


$result = $conexion->query($query);

$reservas = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reserva = array(
            'id_reserva' => $row['id_reserva'],
            'fecha_solicitud' => $row['fecha_solicitud'],
            'fecha_alquiler' => $row['fecha_alquiler'],
            'hora_start' => $row['hora_start'],
            'hora_stop' => $row['hora_stop'],
            'nombre' => $row['nombre'],
            'apellido_paterno' => $row['apellido_paterno'],
            'estado' => $row['estado'],
            'numero_mesa' => $row['numero_mesa'],

        );
        $reservas[] = $reserva;
    }
}


// Devolver los usuarios en formato JSON
header('Content-Type: application/json');
echo json_encode($reservas);
?>
