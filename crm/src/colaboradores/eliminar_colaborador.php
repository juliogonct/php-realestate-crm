<?php
// Incluir el archivo de conexión a la base de datos
include_once '../../includes/conexion.php';

// Verificar si se proporcionó un ID de colaborador a eliminar
if (isset($_GET['colab_id'])) {
    // Obtener el ID del colaborador a eliminar
    $colab_id = $_GET['colab_id'];

    // Crear la consulta SQL para eliminar el colaborador
    $consulta = "DELETE FROM colaboradores WHERE colab_id = $colab_id";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $consulta)) {
        // Cerrar la conexión
        mysqli_close($conexion);

        // Redireccionar a la página de tus colaboradores con un mensaje de éxito
        header("Location: mis_colaboradores.php?mensaje=Colaborador eliminado correctamente");
        exit();
    } else {
        // Cerrar la conexión
        mysqli_close($conexion);

        // Si hay un error, redireccionar a la página de tus colaboradores con un mensaje de error
        header("Location: mis_colaboradores.php?error=Error al eliminar el colaborador");
        exit();
    }
} else {
    // Si no se proporcionó un ID de colaborador, redireccionar a la página de tus colaboradores con un mensaje de error
    header("Location: mis_colaboradores.php?error=ID de colaborador no proporcionado");
    exit();
}