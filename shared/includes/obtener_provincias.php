<?php
include 'obtener_conexion.php';

$ccaa = $_GET['ccaa'];

$query = "SELECT * FROM provincias WHERE provincia_CCAA = $ccaa";
$result = mysqli_query($conexion, $query);

$provincias = array();
while ($row = mysqli_fetch_assoc($result)) {
    $provincias[] = $row;
}

mysqli_free_result($result);
mysqli_close($conexion);

echo json_encode($provincias);
