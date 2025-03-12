<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Contactos</title>
    <!-- Estilos CSS -->
    <style>
        .container {
            width: calc(100% - 80px);
            padding: 20px;
        }

        /* ==================================================================================================================================================== */

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
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
            position: relative;
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
            margin-top: 20px;
        }

        .paginacion a {
            margin: 0 5px;
            text-decoration: none;
            color: #fff;
        }

        .paginacion a:hover {
            color: #ddd;
        }
    </style>
</head>

<body>

    <?php include '../../templates/sidebar.php'; ?>

    <div id="contenido" class="container">

        <h2>Contactos</h2>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Mensaje</th>
                    <th>Inmueble</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once '../../includes/conexion.php';

                // Proceso de paginación
                $por_pagina = 10;
                $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                $offset = ($pagina_actual - 1) * $por_pagina;

                // Consulta para obtener los contactos ordenados por fecha más reciente
                $consulta = "SELECT * FROM contactos ORDER BY contacto_fecha DESC LIMIT $por_pagina OFFSET $offset";
                $resultado = mysqli_query($conexion, $consulta);

                // Mostrar los contactos en la tabla
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fila['contacto_nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['contacto_email']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['contacto_tlf']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['contacto_mensaje']) . "</td>";
                    echo "<td>" . ($fila['contacto_inmueble_id'] ? "Interesado en inmueble: " . htmlspecialchars($fila['contacto_inmueble_id']) : "") . "</td>";
                    echo "<td>" . htmlspecialchars($fila['contacto_fecha']) . "</td>";
                    echo "</tr>";
                }

                // Liberar el resultado
                mysqli_free_result($resultado);
                ?>
            </tbody>
        </table>

        <div class="paginacion">
            <?php
            // Calcular el número total de páginas
            $consulta_total = "SELECT COUNT(*) AS total FROM contactos";
            $resultado_total = mysqli_query($conexion, $consulta_total);
            $fila_total = mysqli_fetch_assoc($resultado_total);
            $total_contactos = $fila_total['total'];
            $total_paginas = ceil($total_contactos / $por_pagina);

            // Mostrar enlaces de paginación
            for ($i = 1; $i <= $total_paginas; $i++) {
                echo "<a href='mis_contactos.php?pagina=$i' class='btn'>" . $i . "</a> ";
            }

            // Liberar el resultado y cerrar la conexión
            mysqli_free_result($resultado_total);
            mysqli_close($conexion);
            ?>
        </div>

    </div>

</body>

</html>
