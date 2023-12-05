<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "billar";
$conexion= new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener los usuarios con su tipo de empleado
$query = "SELECT persona.ci, persona.correo, persona.nombre, persona.telefono, 
        persona.apellido_paterno, persona.apellido_materno, 
        tipo_empleado.descripcion, empleado.estado, empleado.id_empleado
        FROM persona 
        INNER JOIN empleado ON persona.id_persona = empleado.id_personaLF
        INNER JOIN tipo_empleado ON tipo_empleado.id_tipo_empleado = empleado.id_tipo_empleadoLF

        ";
        
        

$result = $conexion->query($query);

$empleados = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empleado = array(
            'ci' => $row['ci'],
            'nombre' => $row['nombre'],
            'apellido_paterno' => $row['apellido_paterno'],
            'apellido_materno' => $row['apellido_materno'],
            'correo' => $row['correo'],
            'telefono' => $row['telefono'],
            'descripcion' => $row['descripcion'],
            'estado' => $row['estado'],
            'id_empleado' => $row['id_empleado']
        );
        $empleados[] = $empleado;
    }
}

// Cerrar la conexión a la base de datos
//$conexion->close();

// Devolver los usuarios en formato JSON
header('Content-Type: application/json');
echo json_encode($empleados);
?>
