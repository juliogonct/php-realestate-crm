<?php
// Incluir archivo de conexión a la base de datos
include_once '../../includes/conexion.php';

// Verificar si se recibió el ID del inmueble
if (isset($_GET['id'])) {
    $inmueble_id = $_GET['id'];

    // Obtener el estado actual de inmueble_publico
    $consulta_estado = "SELECT inmueble_publico FROM inmuebles WHERE inmueble_id = $inmueble_id";
    $resultado_estado = mysqli_query($conexion, $consulta_estado);

    if ($resultado_estado && mysqli_num_rows($resultado_estado) > 0) {
        $fila_estado = mysqli_fetch_assoc($resultado_estado);
        $estado_actual = $fila_estado['inmueble_publico'];

        // Cambiar el estado de inmueble_publico
        $nuevo_estado = $estado_actual == 1 ? 0 : 1;

        // Actualizar la base de datos con el nuevo estado
        $consulta_actualizar = "UPDATE inmuebles SET inmueble_publico = $nuevo_estado WHERE inmueble_id = $inmueble_id";
        $resultado_actualizar = mysqli_query($conexion, $consulta_actualizar);

        if ($resultado_actualizar) {
            // Redireccionar a la página de origen
            header("Location: mis_inmuebles.php");
            exit();
        } else {
            echo "Error al actualizar el estado del inmueble.";
        }
    } else {
        echo "No se encontró el inmueble.";
    }
} else {
    echo "ID de inmueble no especificado.";
}
