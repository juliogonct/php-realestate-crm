<?php
// Iniciar la sesión al principio para evitar errores de cabecera
session_start();

// Incluir el archivo de conexión a la base de datos
include '../../shared/includes/obtener_conexion.php';

// Establecer la consulta SQL base con orden por fecha más reciente
$consulta = "SELECT 
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
    WHERE inmueble_publico = 1
    ORDER BY inmueble_fecha DESC";

// Si existe una consulta en la sesión y no está vacía, usar esa consulta
if (isset($_SESSION['consulta']) && !empty($_SESSION['consulta'])) {
    $consulta = $_SESSION['consulta'];
    error_log("Consulta usada de sesión: " . $consulta);
} else {
    error_log("No se encontró consulta en sesión, usando consulta por defecto.");
}

$resultado = $conexion->query($consulta);


// Determinar el modo de visualización basado en la entrada del usuario
$modo_vista = 'grid'; // Modo por defecto
if (isset($_GET['view_mode']) && in_array($_GET['view_mode'], ['list', 'grid'])) {
    $modo_vista = $_GET['view_mode'];
    $_SESSION['view_mode'] = $modo_vista; // Opcional: guardar en sesión
} elseif (isset($_SESSION['view_mode'])) {
    $modo_vista = $_SESSION['view_mode'];
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Gestión Inmobiliaria</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .box {
            display: flex;
            width: 100%;
        }

        .box .box1 {
            width: 350px;
            padding-left: 20px;
        }

        .box .box2 {
            flex: 1;
            /*Ocupar ancho restante*/
            padding: 20px;
        }

        .buscador {
            max-height: 75px;
            background-color: #ffffff;
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Estilos para pantallas grandes */
        @media (max-width: 900px) {
            .box {
                flex-direction: column;
            }

            .box .box1,
            .box .box2 {
                width: 90%;
            }

            /* Ocultar los botones de modo en pantallas pequeñas */
            .box1 .modo_vista {
                display: none;
            }

            .filtro_avanzado {
                display: none;
            }

            .filtro_btn {
                width: 100%;
                padding: 10px 15px;
                margin: 5px 0;
                font-size: 16px;
                background-color: #091a2b;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
                display: block;
            }

            .filtro_btn:hover {
                background-color: #218838;
            }

            .filtro_btn:active {
                transform: scale(0.98);
            }

        }

        /* Estilos para pantallas grandes */
        @media (min-width: 901px) {

            /* Mostrar siempre el filtro avanzado en pantallas grandes */
            .filtro_avanzado {
                display: block !important;
            }

            /* Ocultar el botón en pantallas grandes */
            .filtro_btn {
                display: none;
            }
        }

        /* ======================================================================================================================== */

        .box1 form {
            margin-top: 20px;
        }

        .box1 .filtro_btn button,
        .filtro-panel button {
            width: 100%;
            padding: 10px 15px;
            margin: 5px 0;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .box1 button:hover {
            background-color: #0056b3;
        }

        .box1 button:active {
            transform: scale(0.98);
        }

        /* Estilo para los botones divididos */
        .split-button {
            display: flex;
            justify-content: center;
        }

        .split-button button {
            height: 75px;
            flex: 1;
            padding: 10px 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
            background-color: #091a2b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .split-button button:hover {
            background-color: #3b4876;
        }

        .split-button button:first-child {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .split-button button:last-child {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
</head>

<body>
    <?php include '../templates/navbar.php'; ?>

    <br><br><br><br>

    <div class="box">

        <div class="box1">

            <!-- Botones para elegir el estilo de visualización de los inmuebles -->
            <form class="modo_vista" action="" method="get">
                <div class="split-button">
                    <button type="submit" name="view_mode" value="list">Lista</button>
                    <button type="submit" name="view_mode" value="grid">Cuadrícula</button>
                </div>
            </form><br>

            <!-- Botón para mostrar/ocultar filtro avanzado en pantallas pequeñas -->
            <button class="filtro_btn" onclick="toggleFiltro()">Filtro</button>

            <!-- Formulario de filtro avanzado -->
            <div class="filtro_avanzado" id="filtroAvanzado">
                <?php include 'filtro_avanzado.php'; ?>
            </div>
        </div>

        <div class="box2">

            <?php
            if ($modo_vista == 'grid') {
                include 'grid.php';
            } else {
                include 'lista.php';
            }
            ?>

        </div>

    </div>

    <?php include '../templates/footer.php'; ?>

</body>
<script>
    // Función para mostrar/ocultar el filtro avanzado
    function toggleFiltro() {
        var filtro = document.getElementById("filtroAvanzado");
        if (filtro.style.display === "block") {
            filtro.style.display = "none";
        } else {
            filtro.style.display = "block";
        }
    }
</script>

</html>