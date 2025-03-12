<?php
// Incluir archivo de conexión a la base de datos
include_once '../../includes/conexion.php';

// Verificar si se recibió el ID del inmueble
if (isset($_GET['id'])) {
    $inmueble_id = $_GET['id'];

    // Obtener la fecha actual
    $fecha_actual = date('Y-m-d');

    // Actualizar la fecha del inmueble
    $consulta_actualizar = "UPDATE inmuebles SET inmueble_fecha = '$fecha_actual' WHERE inmueble_id = $inmueble_id";
    $resultado_actualizar = mysqli_query($conexion, $consulta_actualizar);

    if ($resultado_actualizar) {
        // Redireccionar a la página de origen
        header("Location: mis_inmuebles.php");
        exit();
    } else {
        echo "Error al actualizar la fecha del inmueble.";
    }
} else {
    echo "ID de inmueble no especificado.";
}