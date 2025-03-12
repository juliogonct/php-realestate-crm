<?php
// Incluir el archivo de conexión a la base de datos
include_once '../../includes/conexion.php';

// Verificar si se proporcionó un ID de inmueble a eliminar
if (isset($_GET['id'])) {
    // Obtener el ID del inmueble a eliminar
    $inmueble_id = $_GET['id'];

    // Carpeta que contiene las imágenes del inmueble
    $carpeta_imagenes_inmueble = '../../../shared/images/inmuebles/' . $inmueble_id . '/';

    // Crear la consulta SQL para eliminar el inmueble
    $consulta = "DELETE FROM inmuebles WHERE inmueble_id = $inmueble_id";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $consulta)) {
        // Cerrar la conexión
        mysqli_close($conexion);

        // Eliminar la carpeta y su contenido si existe
        if (file_exists($carpeta_imagenes_inmueble)) {
            eliminarDirectorio($carpeta_imagenes_inmueble);
        }

        // Redireccionar a la página de mis inmuebles con un mensaje de éxito
        header("Location: mis_inmuebles.php?mensaje=Inmueble eliminado correctamente");
        exit();
    } else {
        // Cerrar la conexión
        mysqli_close($conexion);

        // Si hay un error, redireccionar a la página de mis inmuebles con un mensaje de error
        header("Location: mis_inmuebles.php?error=Error al eliminar el inmueble");
        exit();
    }
} else {
    // Si no se proporcionó un ID de inmueble, redireccionar a la página de mis inmuebles con un mensaje de error
    header("Location: mis_inmuebles.php?error=ID de inmueble no proporcionado");
    exit();
}

// Función para eliminar un directorio y su contenido de forma recursiva
function eliminarDirectorio($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!eliminarDirectorio($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}
