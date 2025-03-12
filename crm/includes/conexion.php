<?php include '../../includes/check_login.php'; ?> 

<?php
// Datos de conexión a la base de datos
$host = "localhost"; 
$usuario = "root"; 
$contrasena = ""; 
$base_datos = "inmobiliaria";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar si hay errores en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
