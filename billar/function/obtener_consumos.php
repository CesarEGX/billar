<?php
// Tu conexión a la base de datos aquí
$conexion = new mysqli('localhost', 'tu_usuario', 'tu_contraseña', 'tu_base_de_datos');

if (isset($_GET['id_reserva'])) {
    $id_reserva = $_GET['id_reserva'];

    $consulta = "SELECT ac.*, pr.nombre 
        FROM anadir_consumo ac
        INNER JOIN producto pr ON ac.id_productoLF = pr.id_producto
        WHERE ac.id_reservaLF = '$id_reserva'
        ORDER BY ac.id_anadir_consumo DESC
    ";

    $resultado = $conexion->query($consulta);

    $datos = array();

    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    // Devolver los datos en formato JSON
    echo json_encode($datos);
}
?>
