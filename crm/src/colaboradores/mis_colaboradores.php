<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Colaboradores</title>
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
            <form method="post" action="mis_colaboradores.php" style="width: 100%; display: flex;">

                <div class="field-container">
                    <div class="form-group">
                        <label for="colab_tipo">Tipo de Colaborador:</label>
                        <select name="colab_tipo" id="colab_tipo">
                            <option value="" default selected> Todos </option>
                            <option value="Agente Inmobiliario">Agente Inmobiliario</option>
                            <option value="Asesor Financiero">Asesor Financiero</option>
                            <option value="Abogado">Abogado</option>
                            <option value="Inspector">Inspector</option>
                            <option value="Tasador">Tasador</option>
                            <option value="Notario">Notario</option>
                        </select>
                    </div>
                </div>

                <div class="field-container">
                    <div class="form-group">
                        <label for="colab_nombre">Buscar por Nombre:</label>
                        <input type="text" id="colab_nombre" name="colab_nombre" placeholder="Nombre"
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
            $filtro_tipo = isset($_POST['colab_tipo']) ? mysqli_real_escape_string($conexion, $_POST['colab_tipo']) : '';
            $filtro_nombre = isset($_POST['colab_nombre']) ? mysqli_real_escape_string($conexion, $_POST['colab_nombre']) : '';

            // Construcción de la consulta SQL con filtros
            $consulta = "SELECT * FROM colaboradores WHERE 1=1 ";
            if (!empty($filtro_tipo)) {
                $consulta .= "AND colab_tipo = '$filtro_tipo' ";
            }
            if (!empty($filtro_nombre)) {
                $consulta .= "AND colab_nombre LIKE '%$filtro_nombre%' ";
            }
            $consulta .= "LIMIT $por_pagina OFFSET $offset";

            $resultado = mysqli_query($conexion, $consulta);

            // Calcular el número total de colaboradores para la paginación
            $consulta_total = "SELECT COUNT(*) AS total FROM colaboradores WHERE 1=1 ";
            if (!empty($filtro_tipo)) {
                $consulta_total .= "AND colab_tipo = '$filtro_tipo' ";
            }
            if (!empty($filtro_nombre)) {
                $consulta_total .= "AND colab_nombre LIKE '%$filtro_nombre%' ";
            }
            $resultado_total = mysqli_query($conexion, $consulta_total);
            $fila_total = mysqli_fetch_assoc($resultado_total);
            $total_colabs = $fila_total['total'];
            $total_paginas = ceil($total_colabs / $por_pagina);

            // Verificar si hay resultados
            if (mysqli_num_rows($resultado) > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Tipo de Colaborador</th>";
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
                    echo "<td>" . htmlspecialchars($fila['colab_tipo']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['colab_nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['colab_dni']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['colab_tlf1']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['colab_tlf2']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['colab_email']) . "</td>";
                    echo "<td style='width: 400px;'>" . htmlspecialchars($fila['colab_comentario']) . "</td>";

                    // Botones de editar y eliminar
                    echo "<td style='width: 200px; white-space: nowrap;'>"; // Ajuste del ancho 
                    echo "<a href='insertar_colaborador.php?colab_id=" . htmlspecialchars($fila['colab_id']) . "' class='btn-accion'>Editar</a> ";
                    echo "<a href='eliminar_colaborador.php?colab_id=" . htmlspecialchars($fila['colab_id']) . "' class='btn-accion' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este colaborador?\")'>Eliminar</a>";
                    echo "</td>";

                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No se encontraron colaboradores.";
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
                    echo "<a href='mis_colaboradores.php?pagina=$i' class='btn'>" . $i . "</a> ";
                }
                ?>
            </div>

        </div>

    </div>

</body>

</html>