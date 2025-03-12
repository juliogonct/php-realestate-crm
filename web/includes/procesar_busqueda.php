<?php
session_start();
include '../../shared/includes/obtener_conexion.php';

// Lista de campos no permitidos que serán bloqueados
$camposNoPermitidos = [
    'inmueble_id',
    'inmueble_descripcion',
    'inmueble_propietario',
    'inmueble_colab',
    'inmueble_publico'
];

// Consulta base con solo los inmueble_publico = 1 (Inmuebles publicados)
$baseQuery = "SELECT 
        inmueble_id, 
        inmueble_tipo_inmueble, 
        inmueble_tipo_vivienda, 
        inmueble_tipo_contrato, 
        inmueble_dir, 
        inmueble_ccaa, 
        inmueble_provincia, 
        inmueble_municipio, 
        inmueble_precio, 
        inmueble_superficie, 
        inmueble_habitaciones, 
        inmueble_banos, 
        inmueble_orientacion, 
        inmueble_estado, 
        inmueble_antiguedad, 
        inmueble_descripcion, 
        inmueble_certificado, 
        inmueble_fecha 
    FROM inmuebles 
    WHERE inmueble_publico = 1";

foreach ($_POST as $campo => $valor) {
    if (!in_array($campo, $camposNoPermitidos) && !empty($valor)) {
        $safeValue = $conexion->real_escape_string($valor);
        if ($campo == 'inmueble_precio') {
            // Para inmueble_precio, buscar elementos que tengan el número introducido o menos
            $baseQuery .= " AND $campo <= '$safeValue'";
            // Para inmueble_superficie, inmueble_habitaciones e inmueble_banos, buscar elementos que tengan el número introducido o más
        } elseif ($campo == 'inmueble_superficie' || $campo == 'inmueble_habitaciones' || $campo == 'inmueble_banos') {
            $baseQuery .= " AND $campo >= '$safeValue'";
            // Para el resto de casos, buscar el valor exacto
        } else {
            $baseQuery .= " AND $campo = '$safeValue'";
        }
    }
}

// Ordenar los resultados por inmuebles más recientes
$baseQuery .= " ORDER BY inmueble_fecha DESC";

// Guarda la consulta final en la sesión y se redirige al usuario a la página de búsqueda
$_SESSION['consulta'] = $baseQuery;
header("Location: ../src/busqueda.php");

exit();