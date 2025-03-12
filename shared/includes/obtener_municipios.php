<?php
include 'obtener_conexion.php';

$provincia = $_GET['provincia'];

$query = "SELECT * FROM municipios WHERE municipio_provincia = $provincia";
$result = mysqli_query($conexion, $query);

$municipios = array();
while ($row = mysqli_fetch_assoc($result)) {
    $municipios[] = $row;
}

mysqli_free_result($result);
mysqli_close($conexion);

echo json_encode($municipios);
