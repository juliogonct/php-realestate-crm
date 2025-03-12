<?php

session_start();

include '../../includes/conexion.php';
include '../../templates/sidebar.php';

// Inicializar variables de sesión si no están definidas
if (!isset($_SESSION['filtro_id'])) {
    $_SESSION['filtro_id'] = '';
}
if (!isset($_SESSION['filtro_dir'])) {
    $_SESSION['filtro_dir'] = '';
}
if (!isset($_SESSION['filtro_estado'])) {
    $_SESSION['filtro_estado'] = '';
}
if (!isset($_SESSION['orden_fecha'])) {
    $_SESSION['orden_fecha'] = 'DESC';
}

// Guardar filtros y paginación en la sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['filtro_id'] = isset($_POST['inmueble_id']) ? mysqli_real_escape_string($conexion, $_POST['inmueble_id']) : '';
    $_SESSION['filtro_dir'] = isset($_POST['inmueble_dir']) ? mysqli_real_escape_string($conexion, $_POST['inmueble_dir']) : '';
    $_SESSION['filtro_estado'] = isset($_POST['estado_inmueble']) && $_POST['estado_inmueble'] !== '' ? ($_POST['estado_inmueble'] == '1' ? 'AND inmueble_publico = 1' : 'AND inmueble_publico = 0') : '';
    $_SESSION['orden_fecha'] = isset($_POST['orden_fecha']) ? ($_POST['orden_fecha'] == 'ASC' ? 'ASC' : 'DESC') : 'DESC';
}

// Recuperar filtros y paginación de la sesión
$filtro_id = $_SESSION['filtro_id'];
$filtro_dir = $_SESSION['filtro_dir'];
$filtro_estado = $_SESSION['filtro_estado'];
$orden_fecha = $_SESSION['orden_fecha'];

// Proceso de paginación
$pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$por_pagina = 15;
$offset = ($pagina_actual - 1) * $por_pagina;

// Construcción de la consulta SQL con filtros y ordenamiento
$consulta = "SELECT * FROM inmuebles WHERE 1=1 ";
if (!empty($filtro_id)) {
    $consulta .= "AND inmueble_id = '$filtro_id' ";
}
if (!empty($filtro_dir)) {
    $consulta .= "AND inmueble_dir LIKE '%$filtro_dir%' ";
}
if ($filtro_estado !== '') {
    $consulta .= $filtro_estado;
}
$consulta .= " ORDER BY inmueble_fecha $orden_fecha LIMIT $por_pagina OFFSET $offset";

$resultado = mysqli_query($conexion, $consulta);

// Calcular el número total de inmuebles para la paginación
$consulta_total = "SELECT COUNT(*) AS total FROM inmuebles WHERE 1=1 ";
if (!empty($filtro_id)) {
    $consulta_total .= "AND inmueble_id = '$filtro_id' ";
}
if (!empty($filtro_dir)) {
    $consulta_total .= "AND inmueble_dir LIKE '%$filtro_dir%' ";
}
if ($filtro_estado !== '') {
    $consulta_total .= $filtro_estado;
}
$resultado_total = mysqli_query($conexion, $consulta_total);
$fila_total = mysqli_fetch_assoc($resultado_total);
$total_inmuebles = $fila_total['total'];
$total_paginas = ceil($total_inmuebles / $por_pagina);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Inmuebles</title>
    <style>
        .container {
            margin-top: 20px;
            margin-left: 20px;
            background-color: #ffffff;
            padding: 10px 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .field-container {
            flex: 1 1 30%;
            min-width: 250px;
            margin-right: 30px;
        }

        .field-container:last-child {
            margin-right: 0;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }

        input[type="text"],
        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #091a2b;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }

        input[type="submit"]:hover {
            background-color: #1C2840;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        /* ==================================================================================================================================================== */

        table {
            margin-top: 20px;
            margin-left: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            min-width: 50px;
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #091a2b;
            color: white;
        }

        td {
            background-color: #ffffff;
        }

        /* ==================================================================================================================================================== */

        .btn,
        button {
            padding: 10px 20px;
            background-color: #243040;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn:hover,
        button:hover {
            background-color: #1C2840;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        .btn-accion {
            background-color: #243040;
            color: #fff;
            padding: 8px 16px;
            margin-right: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-accion:hover {
            background-color: #1C2840;
        }


        /* ==================================================================================================================================================== */

        .paginacion {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div id="contenedor">
        <div class="container">
            <form method="post" action="mis_inmuebles.php" style="width: 100%; display: flex;">
                <div class="field-container">
                    <div class="form-group">
                        <label for="inmueble_id">Buscar por ID:</label>
                        <input type="text" id="inmueble_id" name="inmueble_id" placeholder="ID" list="datalist_id"
                            autocomplete="off" value="<?php echo htmlspecialchars($filtro_id); ?>">
                        <datalist id="datalist_id"></datalist>
                    </div>
                </div>

                <div class="field-container">
                    <div class="form-group">
                        <label for="inmueble_dir">Buscar por Dirección:</label>
                        <input type="text" id="inmueble_dir" name="inmueble_dir" placeholder="Dirección"
                            list="datalist_dir" autocomplete="off" value="<?php echo htmlspecialchars($filtro_dir); ?>">
                        <datalist id="datalist_dir"></datalist>
                    </div>
                </div>

                <div class="field-container">
                    <div class="form-group">
                        <label for="estado_inmueble">Estado:</label>
                        <select id="estado_inmueble" name="estado_inmueble">
                            <option value="" <?php echo $filtro_estado == '' ? 'selected' : ''; ?>>Todos</option>
                            <option value="1" <?php echo $filtro_estado == 'AND inmueble_publico = 1' ? 'selected' : ''; ?>>
                                Publicados</option>
                            <option value="0" <?php echo $filtro_estado == 'AND inmueble_publico = 0' ? 'selected' : ''; ?>>
                                Sin Publicar</option>
                        </select>
                    </div>
                </div>

                <div class="field-container">
                    <div class="form-group">
                        <label for="orden_fecha">Ordenar por fecha:</label>
                        <select id="orden_fecha" name="orden_fecha">
                            <option value="DESC" <?php echo $orden_fecha == 'DESC' ? 'selected' : ''; ?>>Descendente
                            </option>
                            <option value="ASC" <?php echo $orden_fecha == 'ASC' ? 'selected' : ''; ?>>Ascendente</option>
                        </select>
                    </div>
                </div>

                <input type="submit" value="Buscar">
            </form>
        </div>

        <div id="contenido">
            <?php
            // Verificar si hay resultados
            if (mysqli_num_rows($resultado) > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Tipo de inmueble</th>";
                echo "<th>Tipo de vivienda</th>";
                echo "<th>Tipo de contrato</th>";
                echo "<th>Dirección</th>";
                echo "<th>Localidad</th>";
                echo "<th>Precio</th>";
                echo "<th>Habit.</th>";
                echo "<th>Baños</th>";
                echo "<th>Fecha</th>";
                echo "<th>Publicado</th>";
                echo "<th>Acciones</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Mostrar los datos en la tabla
                $columnas_excluidas = ['inmueble_ccaa', 'inmueble_provincia', 'inmueble_superficie', 'inmueble_estado', 'inmueble_antiguedad', 'inmueble_certificado', 'inmueble_descripcion', 'inmueble_orientacion', 'inmueble_propietario', 'inmueble_colab'];

                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    foreach ($fila as $columna => $valor) {
                        if (!in_array($columna, $columnas_excluidas)) {
                            // Verificar si la columna es 'inmueble_publico'
                            if ($columna === 'inmueble_publico') {
                                // Mostrar 'sí' si el valor es 1, 'no' si es 0
                                echo "<td>" . ($valor == 1 ? 'Sí' : 'No') . "</td>";
                            } else {
                                // Mostrar otros valores sin modificaciones
                                echo "<td>" . htmlspecialchars($valor) . "</td>";
                            }
                        }
                    }

                    // Obtener el ID del inmueble
                    $inmueble_id = $fila['inmueble_id'];
                    $inmueble_publico = $fila['inmueble_publico'];

                    // Agregar los botones al final de la fila
                    echo "<td style='width: 200px; white-space: nowrap;'>"; // Ajuste del ancho 
                    echo "<a href='../../../web/src/detalle_inmueble.php?id=$inmueble_id&pagina=$pagina_actual' class='btn-accion'>Ver</a> ";
                    echo "<a href='insertar_inmueble.php?id=$inmueble_id&pagina=$pagina_actual' class='btn-accion'>Editar</a> ";
                    echo "<a href='actualizar_inmueble.php?id=$inmueble_id&pagina=$pagina_actual' class='btn-accion'>Actualizar</a>";
                    echo "<a href='publicar_inmueble.php?id=$inmueble_id&pagina=$pagina_actual' class='btn-accion'>Publicar</a>";
                    echo "<a href='eliminar_inmueble.php?id=$inmueble_id&pagina=$pagina_actual' class='btn-accion' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este inmueble?\")'>Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No se encontraron inmuebles.";
            }

            // Liberar el resultado
            mysqli_free_result($resultado);

            // Cerrar la conexión
            mysqli_close($conexion);
            ?>
            <br>

            <div class="paginacion">
                <?php
                for ($i = 1; $i <= $total_paginas; $i++) {
                    echo "<a href='mis_inmuebles.php?pagina=$i' class='btn'>" . $i . "</a> ";
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>