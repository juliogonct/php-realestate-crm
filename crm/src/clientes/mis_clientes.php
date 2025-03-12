<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Clientes</title>
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
            min-width: 100px;
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

<?php include '../../templates/sidebar.php'; ?>

<body>

    <div id="contenedor">
        <div class="container">
            <form method="post" action="mis_clientes.php" style="width: 100%; display: flex;">

                <div class="field-container">
                    <div class="form-group">
                        <label for="cliente_tipo">Tipo de Cliente:</label>
                        <select name="cliente_tipo" id="cliente_tipo">
                            <option value="" default selected> Todos </option>
                            <option value="Demandante">Demandante</option>
                            <option value="Propietario">Propietario</option>
                            <option value="Inversionista">Inversionista</option>
                            <option value="Arrendatario">Arrendatario</option>
                            <option value="Promotor inmobiliario">Promotor inmobiliario</option>
                        </select>
                    </div>
                </div>

                <div class="field-container">
                    <div class="form-group">
                        <label for="cliente_nombre">Buscar por Nombre:</label>
                        <input type="text" id="cliente_nombre" name="cliente_nombre" placeholder="Nombre"
                            list="datalist_nombre" autocomplete="off">
                        <datalist id="datalist_nombre"></datalist>
                    </div>
                </div>

                <input type="submit" value="Buscar">
            </form>
        </div>

        <!-- ======================================================================================================================== -->

        <div id="contenido">

            <?php
            include_once '../../includes/conexion.php';

            // Proceso de paginación
            $pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
            $por_pagina = 15;
            $offset = ($pagina_actual - 1) * $por_pagina;

            // Proceso de filtrado
            $filtro_tipo = isset($_POST['cliente_tipo']) ? mysqli_real_escape_string($conexion, $_POST['cliente_tipo']) : '';
            $filtro_nombre = isset($_POST['cliente_nombre']) ? mysqli_real_escape_string($conexion, $_POST['cliente_nombre']) : '';

            // Construcción de la consulta SQL con filtros
            $consulta = "SELECT * FROM clientes WHERE 1=1 ";
            if (!empty($filtro_tipo)) {
                $consulta .= "AND cliente_tipo = '$filtro_tipo' ";
            }
            if (!empty($filtro_nombre)) {
                $consulta .= "AND cliente_nombre LIKE '%$filtro_nombre%' ";
            }
            $consulta .= "LIMIT $por_pagina OFFSET $offset";

            $resultado = mysqli_query($conexion, $consulta);

            // Calcular el número total de clientes para la paginación
            $consulta_total = "SELECT COUNT(*) AS total FROM clientes WHERE 1=1 ";
            if (!empty($filtro_tipo)) {
                $consulta_total .= "AND cliente_tipo = '$filtro_tipo' ";
            }
            if (!empty($filtro_nombre)) {
                $consulta_total .= "AND cliente_nombre LIKE '%$filtro_nombre%' ";
            }
            $resultado_total = mysqli_query($conexion, $consulta_total);
            $fila_total = mysqli_fetch_assoc($resultado_total);
            $total_clientes = $fila_total['total'];
            $total_paginas = ceil($total_clientes / $por_pagina);

            // Verificar si hay resultados
            if (mysqli_num_rows($resultado) > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Tipo de Cliente</th>";
                echo "<th>Nombre</th>";
                echo "<th>DNI</th>";
                echo "<th>Teléfono 1</th>";
                echo "<th>Teléfono 2</th>";
                echo "<th>Email</th>";
                echo "<th style='width: 400px;'>Comentario</th>"; // Aquí establece el ancho deseado
                echo "<th>Acciones</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Mostrar los datos en la tabla
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fila['cliente_tipo']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['cliente_nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['cliente_dni']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['cliente_tlf1']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['cliente_tlf2']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['cliente_email']) . "</td>";
                    echo "<td style='width: 400px;'>" . htmlspecialchars($fila['cliente_comentario']) . "</td>";

                    // Botones de editar y eliminar
                    echo "<td style='width: 200px; white-space: nowrap;'>"; // Ajuste del ancho 
                    echo "<a href='insertar_cliente.php?cliente_id=" . htmlspecialchars($fila['cliente_id']) . "' class='btn-accion'>Editar</a> ";
                    echo "<a href='eliminar_cliente.php?cliente_id=" . htmlspecialchars($fila['cliente_id']) . "' class='btn-accion' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este cliente?\")'>Eliminar</a>";
                    echo "</td>";

                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No se encontraron clientes.";
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
                    echo "<a href='mis_clientes.php?pagina=$i' class='btn'>" . $i . "</a> ";
                }
                ?>
            </div>

        </div>

    </div>

</body>

</html>