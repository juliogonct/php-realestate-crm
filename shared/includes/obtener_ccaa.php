<?php
include 'obtener_conexion.php';

$query = "SELECT * FROM ccaa ORDER BY ccaa_nombre ASC";
$result = mysqli_query($conexion, $query);

$ccaa = array();
while ($row = mysqli_fetch_assoc($result)) {
    $ccaa[] = $row;
}

mysqli_free_result($result);
mysqli_close($conexion);

echo json_encode($ccaa);
