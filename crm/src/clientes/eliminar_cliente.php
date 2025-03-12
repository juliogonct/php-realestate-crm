<?php
// Incluir el archivo de conexión a la base de datos
include_once '../../includes/conexion.php';

// Verificar si se proporcionó un ID de cliente a eliminar
if (isset($_GET['cliente_id'])) {
    // Obtener el ID del cliente a eliminar
    $cliente_id = $_GET['cliente_id'];

    // Crear la consulta SQL para eliminar el cliente
    $consulta = "DELETE FROM clientes WHERE cliente_id = $cliente_id";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $consulta)) {
        // Cerrar la conexión
        mysqli_close($conexion);

        // Redireccionar a la página de tus clientes con un mensaje de éxito
        header("Location: mis_clientes.php?mensaje=Cliente eliminado correctamente");
        exit();
    } else {
        // Cerrar la conexión
        mysqli_close($conexion);

        // Si hay un error, redireccionar a la página de tus clientes con un mensaje de error
        header("Location: mis_clientes.php?error=Error al eliminar el cliente");
        exit();
    }
} else {
    // Si no se proporcionó un ID de cliente, redireccionar a la página de tus clientes con un mensaje de error
    header("Location: mis_clientes.php?error=ID de cliente no proporcionado");
    exit();
}