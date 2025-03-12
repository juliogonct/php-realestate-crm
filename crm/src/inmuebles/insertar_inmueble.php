<?php

include '../../templates/sidebar.php';
include '../../includes/conexion.php';

// Inicializar un arreglo vacío para almacenar los datos del inmueble
$inmueble = array(
    'inmueble_tipo_inmueble' => '',
    'inmueble_tipo_vivienda' => '',
    'inmueble_tipo_contrato' => '',
    'inmueble_dir' => '',
    'inmueble_ccaa' => '',
    'inmueble_provincia' => '',
    'inmueble_municipio' => '',
    'inmueble_precio' => '',
    'inmueble_superficie' => '',
    'inmueble_habitaciones' => '',
    'inmueble_banos' => '',
    'inmueble_orientacion' => '',
    'inmueble_estado' => '',
    'inmueble_antiguedad' => '',
    'inmueble_descripcion' => '',
    'inmueble_certificado' => '',
    'inmueble_propietario' => '',
    'inmueble_colab' => '',
);

// Inicializar un arreglo vacío para almacenar los datos de los extras
$extras = array(
    'extra_aire_acondicionado' => '',
    'extra_amueblado' => '',
    'extra_armarios' => '',
    'extra_ascensor' => '',
    'extra_balcon' => '',
    'extra_calefaccion' => '',
    'extra_electrodomesticos' => '',
    'extra_garaje_privado' => '',
    'extra_jardin' => '',
    'extra_lavadero' => '',
    'extra_parquet' => '',
    'extra_parking_comunitario' => '',
    'extra_patio' => '',
    'extra_piscina' => '',
    'extra_suite_con_bano' => '',
    'extra_terrazo' => '',
    'extra_trastero' => '',
    'extra_videoportero' => '',
    'extra_zona_comunitaria' => '',
    'extra_zona_deportiva' => '',
    'extra_zona_infantil' => '',
);

// Verificar si se proporciona un ID de inmueble
if (isset($_GET['id'])) {
    // Obtener el ID del inmueble desde la URL
    $inmueble_id = $_GET['id'];

    // Consultar los datos del inmueble desde la base de datos
    $query = "SELECT * FROM inmuebles WHERE inmueble_id = $inmueble_id";
    $result = mysqli_query($conexion, $query);

    // Verificar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Obtener los datos del inmueble y almacenarlos en el arreglo $inmueble
        $inmueble = mysqli_fetch_assoc($result);
    } else {
        // No se encontraron datos del inmueble, mostrar un mensaje de error o redirigir a una página de error
        echo "El inmueble con ID $inmueble_id no fue encontrado.";
        exit(); // O redirigir a una página de error
    }

    // Liberar el resultado de la consulta
    mysqli_free_result($result);

    // Consultar los datos de los extras desde la base de datos
    $query = "SELECT * FROM extras WHERE inmueble_id = $inmueble_id";
    $result = mysqli_query($conexion, $query);

    // Verificar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Obtener los datos de los extras y almacenarlos en el arreglo $extras
        $extras = mysqli_fetch_assoc($result);
    }

    // Liberar el resultado de la consulta
    mysqli_free_result($result);

    // Agregar JavaScript para ejecutar automáticamente actualizarProvincias() y actualizarMunicipios()
    echo "<script>
            window.onload = function() {
                actualizarProvincias();
                setTimeout(actualizarMunicipios, 1000); // Retraso para asegurar que se ejecute después de actualizar las provincias
            };
          </script>";
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>Insertar Inmueble</title>
    <style>
        /* Estilos específicos para la página */
        #contenido {
            padding: 20px;
            width: calc(100%);
        }

        /********************************************************************************************************************************/

        body {
            font-family: Arial, sans-serif;
        }

        .contenedor {
            background: white;
            border: 1px solid #ccc;
            /* Borde gris */
            border-radius: 10px;
            /* Bordes redondeados */
            padding: 20px;

        }

        /********************************************************************************************************************************/

        form {
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        /********************************************************************************************************************************/

        .form-container {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            width: calc(50% - 30px);
            /* Ancho del contenedor, 50% del ancho de la página menos márgenes */
            box-sizing: border-box;
            display: inline-block;
            /* Mostrar en línea para organizar en dos columnas */
            vertical-align: top;
            /* Alinear en la parte superior */
        }

        .form-container {
            margin-left: 15px;
            margin-right: 10px;
            margin-top: 10px;
            min-height: 400px;
            /* Espacio entre las columnas */
        }

        .form-container h3 {
            margin-top: 0;
        }

        /********************************************************************************************************************************/

        /* Estilos CSS para la disposición en tres columnas en extras*/
        .extras-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        /* Estilos para cada casilla de extra */
        .extra {
            flex-basis: calc(33.33% - 10px);
            /* 33.33% de ancho menos el espacio entre columnas */
            margin-bottom: 10px;
            /* Espacio entre filas */
            display: flex;
            align-items: center;
        }

        .extra label {
            cursor: pointer;
            display: inline-block;
            padding: 5px 8px;
            width: 100%;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Ocultar el input checkbox real */
        .extra input[type="checkbox"] {
            display: none;
        }

        /* Estilo cuando el checkbox está marcado */
        .extra input[type="checkbox"]:checked+label {
            background-color: #007bff;
            color: white;
            border-color: #006fe6;
        }

        /* Estilo para hover sobre cualquier etiqueta */
        .extra label:hover {
            background-color: #e0e0e0;
            color: #333;
        }

        /* Estilo para hover específicamente en etiquetas marcadas */
        .extra input[type="checkbox"]:checked+label:hover {
            background-color: #006fe6;
        }

        /********************************************************************************************************************************/

        #map {
            min-height: 400px;
            margin: -20px;
            border-radius: 10px;
        }

        .map-button {
            width: 100%;
            margin-top: 20px;
        }

        .map-button {
            background-color: #006fe6;
            color: #fff;
            padding: 10px 20px;
            border: 1px #f1f2f4;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .map-button:hover {
            background-color: #000;
        }

        #imagenes-marco iframe {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding-left: 10px;
            margin-left: 15px;
            margin-bottom: 20px;
            width: calc(100% - 30px);
            min-height: 400px;
            box-sizing: border-box;
            display: inline-block;
            vertical-align: top;
        }

        #descripcion-marco {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding-left: 20px;
            padding-bottom: 20px;
            margin-left: 15px;
            margin-bottom: 20px;
            width: calc(100% - 30px);
            min-height: 400px;
            box-sizing: border-box;
            display: inline-block;
            vertical-align: top;
        }

        /********************************************************************************************************************************/

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            width: 100%;
            min-height: 600px;
            border: #ccc;
            outline: none;
            resize: none;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #4a4a4a;
            width: 100%;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>

<body>

    <div id="contenido">
        <form action="procesar_inmueble.php" method="POST" onsubmit="return validarFormulario()"
            enctype="multipart/form-data">

            <!-- Campo oculto para el ID del inmueble -->
            <input type="hidden" name="inmueble_id"
                value="<?php echo isset($inmueble['inmueble_id']) ? $inmueble['inmueble_id'] : ''; ?>">

            <!-- ======================================================================================================================== -->

            <section class="contenedor">

                <div class="form-container">

                    <label for="tipo_inmueble">Tipo de Inmueble:</label>
                    <select name="tipo_inmueble" id="tipo_inmueble" onchange="habilitarTipoVivienda()">
                        <option value="" disabled> -- Escoja una opción -- </option>
                        <?php
                        $tipos_inmueble = array("Vivienda", "Garaje", "Terreno", "Local", "Oficina", "Trastero");
                        foreach ($tipos_inmueble as $tipo) {
                            echo '<option value="' . $tipo . '"';
                            echo $inmueble['inmueble_tipo_inmueble'] == $tipo ? ' selected' : '';
                            echo '>' . $tipo . '</option>';
                        }
                        ?>
                    </select><br>

                    <!-- ======================================================================================================================== -->

                    <label for="tipo_vivienda">Tipo de Vivienda:</label>
                    <select name="tipo_vivienda" id="tipo_vivienda" <?php echo $inmueble['inmueble_tipo_inmueble'] != 'Vivienda' ? 'disabled' : ''; ?>>
                        <option value="" disabled> -- Escoja una opción -- </option>
                        <?php
                        $tipos_vivienda = array("Piso", "Apartamento", "Ático", "Dúplex", "Estudio", "Loft", "Chalet", "Planta baja", "Finca rústica", "Casa adosada");
                        foreach ($tipos_vivienda as $tipo) {
                            echo '<option value="' . $tipo . '"';
                            echo $inmueble['inmueble_tipo_vivienda'] == $tipo ? ' selected' : '';
                            echo '>' . $tipo . '</option>';
                        }
                        ?>
                    </select><br>


                    <!-- ======================================================================================================================== -->

                    <label for="tipo_contrato">Tipo de Contrato:</label>
                    <select name="tipo_contrato" id="tipo_contrato">
                        <option value="Alquiler" <?php echo isset($inmueble['inmueble_tipo_contrato']) && $inmueble['inmueble_tipo_contrato'] == "Alquiler" ? 'selected' : ''; ?>>Alquiler</option>
                        <option value="Venta" <?php echo isset($inmueble['inmueble_tipo_contrato']) && $inmueble['inmueble_tipo_contrato'] == "Venta" ? 'selected' : ''; ?>>Venta</option>
                        <option value="Compartir" <?php echo isset($inmueble['inmueble_tipo_contrato']) && $inmueble['inmueble_tipo_contrato'] == "Compartir" ? 'selected' : ''; ?>>Compartir</option>
                    </select><br><br><br><br><br>

                </div>

                <!-- ======================================================================================================================== -->

                <div class="form-container">

                    <label for="precio">Precio:</label>
                    <input type="number" name="precio"
                        value="<?php echo isset($inmueble['inmueble_precio']) ? $inmueble['inmueble_precio'] : ''; ?>">

                    <br>

                    <label for="superficie">Superficie:</label>
                    <input type="number" name="superficie" id="superficie"
                        value="<?php echo isset($inmueble['inmueble_superficie']) ? $inmueble['inmueble_superficie'] : ''; ?>">

                    <br>

                    <label for="habitaciones">Habitaciones:</label>
                    <input type="number" name="habitaciones" id="habitaciones"
                        value="<?php echo isset($inmueble['inmueble_habitaciones']) ? $inmueble['inmueble_habitaciones'] : ''; ?>">

                    <br>

                    <label for="banos">Baños:</label>
                    <input type="number" name="banos" id="banos"
                        value="<?php echo isset($inmueble['inmueble_banos']) ? $inmueble['inmueble_banos'] : ''; ?>">

                    <br>

                </div>

                <!-- ======================================================================================================================== -->

                <div class="form-container">

                    <label for="dir">Dirección:</label>
                    <input type="text" name="direccion"
                        value="<?php echo isset($inmueble['inmueble_dir']) ? $inmueble['inmueble_dir'] : ''; ?>">


                    <label for="ccaa">Comunidad Autónoma:</label>
                    <select name="ccaa" id="ccaa" onchange="actualizarProvincias()">
                        <option value="" disabled selected> -- Escoja una opción -- </option>
                        <?php
                        // Consultar las comunidades autónomas desde la base de datos y generar las opciones
                        include '../../includes/conexion.php';
                        $query = "SELECT * FROM ccaa ORDER BY ccaa_nombre ASC";
                        $result = mysqli_query($conexion, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Verificar si hay un inmueble seleccionado y si el nombre de la comunidad autónoma coincide
                            $selected = ($inmueble['inmueble_ccaa'] == $row['ccaa_nombre']) ? 'selected' : '';
                            echo "<option value='" . $row['ccaa_id'] . "' $selected>" . $row['ccaa_nombre'] . "</option>";
                        }
                        mysqli_free_result($result);
                        ?>
                    </select><br>

                    <label for="provincia">Provincia:</label>
                    <select name="provincia" id="provincia" onchange="actualizarMunicipios()">
                        <option value="" disabled selected> -- Escoja una opción -- </option>
                    </select><br>

                    <label for="municipio">Municipio:</label>
                    <select name="municipio" id="municipio">
                        <option value="" disabled selected> -- Escoja una opción -- </option>
                    </select><br>

                    <button type="button" class="map-button" onclick="generarMapa()">Generar Mapa</button>

                </div>

                <!-- ======================================================================================================================== -->

                <div class="form-container">
                    <div id="map"></div>
                </div>

                <!-- ======================================================================================================================== -->

                <div class="form-container">

                    <label for="orientacion">Orientación:</label>
                    <select name="orientacion" id="orientacion">
                        <option value="" disabled selected> -- Escoja una opción -- </option>
                        <?php
                        $orientaciones = array(
                            "Norte",
                            "Noreste",
                            "Noroeste",
                            "Sur",
                            "Sureste",
                            "Suroeste",
                            "Este",
                            "Oeste"
                        );
                        foreach ($orientaciones as $orientacion) {
                            echo '<option value="' . $orientacion . '"';
                            echo $inmueble['inmueble_orientacion'] == $orientacion ? ' selected' : '';
                            echo '>' . $orientacion . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado">
                        <option value="" disabled selected> -- Escoja una opción -- </option>
                        <?php
                        $estados = array(
                            "Nuevo",
                            "Casi nuevo",
                            "Buen estado",
                            "Reformado",
                            "A reformar"
                        );
                        foreach ($estados as $estado) {
                            echo '<option value="' . $estado . '"';
                            echo $inmueble['inmueble_estado'] == $estado ? ' selected' : '';
                            echo '>' . $estado . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="antiguedad">Antigüedad:</label>
                    <select name="antiguedad" id="antiguedad">
                        <option value="" disabled selected> -- Escoja una opción -- </option>
                        <?php
                        $antiguedades = array(
                            "0 a 1 año",
                            "1 a 5 años",
                            "5 a 10 años",
                            "10 a 20 años",
                            "20 a 30 años",
                            "30 a 50 años",
                            "50 a 70 años",
                            "70 a 100 años",
                            "100 años o más"
                        );
                        foreach ($antiguedades as $antiguedad) {
                            echo '<option value="' . $antiguedad . '"';
                            echo $inmueble['inmueble_antiguedad'] == $antiguedad ? ' selected' : '';
                            echo '>' . $antiguedad . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="certificado">Certificado:</label>
                    <select name="certificado" id="certificado">
                        <option value="" disabled selected> -- Escoja una opción -- </option>
                        <?php
                        $certificados = array("Tramitándose", "A", "B", "C", "D", "E", "F", "G");
                        foreach ($certificados as $certificado) {
                            echo '<option value="' . $certificado . '"';
                            echo $inmueble['inmueble_certificado'] == $certificado ? ' selected' : '';
                            echo '>' . $certificado . '</option>';
                        }
                        ?>
                    </select><br>

                </div>

                <!-- ======================================================================================================================== -->

                <div class="form-container">
                    <label for="extras">Extras:</label>
                    <div class="extras-container">
                        <?php
                        // Lista de extras
                        $extrasList = array(
                            "Aire acondicionado",
                            "Amueblado",
                            "Armarios",
                            "Ascensor",
                            "Balcón",
                            "Calefacción",
                            "Electrodomésticos",
                            "Garaje Privado",
                            "Jardín",
                            "Lavadero",
                            "Parquet",
                            "Parking comunitario",
                            "Patio",
                            "Piscina",
                            "Suite con baño",
                            "Terrazo",
                            "Trastero",
                            "Videoportero",
                            "Zona Comunitaria",
                            "Zona Deportiva",
                            "Zona Infantil"
                        );

                        // Generar los checkboxes y etiquetas para cada extra
                        foreach ($extrasList as $extra) {
                            // Convertir el nombre del extra a un formato válido para el atributo "name" del checkbox
                            $extraName = strtolower(str_replace(["á", "é", "í", "ó", "ú", "ñ", " "], ["a", "e", "i", "o", "u", "n", "_"], $extra));

                            // Verificar si el extra está seleccionado
                            $isChecked = isset($extras['extra_' . $extraName]) && $extras['extra_' . $extraName] == 1 ? 'checked' : '';

                            // Imprimir el div extra con el checkbox y la etiqueta
                            echo '<div class="extra">';
                            echo '<input type="checkbox" id="' . $extraName . '" name="extra_' . $extraName . '" ' . $isChecked . '>';
                            echo '<label for="' . $extraName . '">' . $extra . '</label>';
                            echo '</div>';
                        }

                        ?>
                    </div>
                </div><br><br>

                <!-- ======================================================================================================================== -->

                <div id="imagenes-marco">
                    <?php
                    if (isset($inmueble_id) && !empty($inmueble_id)) {
                        echo '<iframe src="insertar_imagenes.php?id=' . $inmueble_id . '"></iframe>';
                        echo '<input type="hidden" id="hiddenInput" name="hiddenInput" value="' . $inmueble_id . '">';
                    } else {
                        echo '<iframe src="insertar_imagenes.php"></iframe>';
                        echo '<input type="hidden" id="hiddenInput" name="hiddenInput" value="">';
                    }
                    ?>
                </div><br>

                <!-- ======================================================================================================================== -->

                <div id="descripcion-marco"><br>
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" cols="30"
                        rows="10"><?php echo isset($inmueble['inmueble_descripcion']) ? $inmueble['inmueble_descripcion'] : ''; ?></textarea><br>
                </div>

                <!-- ======================================================================================================================== -->

                <label for="propietario">Propietario del Inmueble:</label>
                <select name="propietario" id="propietario">
                    <option value="" disabled selected> -- Escoja una opción -- </option>
                    <option value=""> -- Sin propietario -- </option>
                    <?php
                    include '../../includes/conexion.php';
                    $query = "SELECT * FROM clientes WHERE cliente_tipo = 'Propietario' ORDER BY cliente_nombre ASC";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Verificar si hay un inmueble seleccionado y si el propietario coincide
                        $selected = ($inmueble['inmueble_propietario'] == $row['cliente_id']) ? 'selected' : '';
                        echo "<option value='" . $row['cliente_id'] . "' $selected>" . $row['cliente_nombre'] . "</option>";
                    }
                    mysqli_free_result($result);
                    ?>
                </select><br>

                <!-- ======================================================================================================================== -->

                <label for="colab">Colaboradores:</label>
                <select name="colab" id="colab">
                    <option value="" disabled selected> -- Escoja una opción -- </option>
                    <option value=""> -- Sin colaborador -- </option>
                    <?php
                    $query = "SELECT * FROM colaboradores ORDER BY colab_nombre ASC";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Verificar si hay un inmueble seleccionado y si el colaborador coincide
                        $selected = ($inmueble['inmueble_colab'] == $row['colab_id']) ? 'selected' : '';
                        echo "<option value='" . $row['colab_id'] . "' $selected>" . $row['colab_nombre'] . "</option>";
                    }
                    mysqli_free_result($result);
                    ?>
                </select><br><br>

                <!-- ======================================================================================================================== -->

                <button type="submit">Insertar Inmueble</button>

            </section>


        </form>
    </div>


    <!-- Scripts JavaScript -->
    <script>
        function validarFormulario() {
            var campos = ["tipo_inmueble", "tipo_vivienda", "tipo_contrato", "direccion", "provincia", "municipio", "precio", "superficie", "habitaciones", "banos", "orientacion", "estado", "antiguedad", "certificado"];
            var mensajes = {
                "tipo_inmueble": "tipo de inmueble",
                "tipo_vivienda": "tipo de vivienda",
                "tipo_contrato": "tipo de contrato",
                "direccion": "direccion",
                "provincia": "provincia",
                "municipio": "municipio",
                "precio": "precio",
                "superficie": "superficie",
                "habitaciones": "habitaciones",
                "banos": "baños",
                "orientacion": "orientación",
                "estado": "estado",
                "antiguedad": "antigüedad",
                "certificado": "certificado",
            };

            for (var i = 0; i < campos.length; i++) {
                var campo = campos[i];
                var valor = document.getElementById(campo).value;

                // Permitir que tipo_vivienda esté vacío o nulo si tipo_inmueble no es "Vivienda"
                if (campo === "tipo_vivienda" && document.getElementById("tipo_inmueble").value !== "Vivienda") {
                    continue;
                }

                if (valor === "" || valor === " -- Escoja una opción -- ") {
                    alert("Debe seleccionar una opción válida para " + mensajes[campo] + ".");
                    return false;
                }
            }

            // Verificar si el tipo de inmueble es "Vivienda" y el tipo de vivienda está vacío
            var tipoInmueble = document.getElementById("tipo_inmueble").value;
            var tipoVivienda = document.getElementById("tipo_vivienda").value;
            if (tipoInmueble === "Vivienda" && tipoVivienda === "") {
                alert("Debe seleccionar una opción válida para el tipo de vivienda.");
                return false;
            }

            return true;
        }

        /********************************************************************************************************************************/

        function habilitarTipoVivienda() {
            var tipoInmueble = document.getElementById("tipo_inmueble").value;
            var tipoViviendaSelect = document.getElementById("tipo_vivienda");

            if (tipoInmueble === "Vivienda") {
                tipoViviendaSelect.disabled = false; // Habilitar el campo
            } else {
                tipoViviendaSelect.disabled = true; // Deshabilitar el campo
                tipoViviendaSelect.value = ""; // Reiniciar el valor seleccionado
            }
        }
        habilitarTipoVivienda();

        /********************************************************************************************************************************/

        /* actualizarCCAA */

        /* document.addEventListener('DOMContentLoaded', function () {
            fetch('../../../shared/includes/obtener_ccaa.php')
                .then(response => response.json())
                .then(data => {
                    const ccaaSelect = document.getElementById('ccaa');
                    data.forEach(ccaa => {
                        const option = document.createElement('option');
                        option.value = ccaa.ccaa_id;
                        option.textContent = ccaa.ccaa_nombre;
                        ccaaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar las CCAA:', error));
        }); */

        /********************************************************************************************************************************/

        function actualizarProvincias() {
            // Obtener el valor seleccionado de la comunidad autónoma
            var ccaa = document.getElementById("ccaa").value;

            // Seleccionar el elemento del menú desplegable de provincias
            var provinciaSelect = document.getElementById("provincia");

            // Limpiar las opciones actuales del menú desplegable de provincias
            provinciaSelect.innerHTML = "";

            // Realizar una solicitud AJAX para obtener las provincias según la comunidad autónoma seleccionada
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../../../shared/includes/obtener_provincias.php?ccaa=" + ccaa, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Parsear la respuesta JSON recibida del servidor
                    var provincias = JSON.parse(xhr.responseText);

                    // Iterar sobre cada provincia y agregarla al menú desplegable de provincias
                    provincias.forEach(function (provincia) {
                        var option = document.createElement("option");
                        option.text = provincia.provincia_nombre;
                        option.value = provincia.provincia_id;
                        provinciaSelect.add(option);

                        // Selecciona automáticamente la provincia correspondiente al valor del inmueble
                        if (provincia.provincia_nombre == "<?php echo $inmueble['inmueble_provincia']; ?>") {
                            option.selected = true;
                        }
                    });

                    // Después de actualizar las provincias, también actualizamos los municipios
                    actualizarMunicipios();
                }
            };
            xhr.send(); // Enviar la solicitud AJAX al servidor
        }

        /********************************************************************************************************************************/

        function actualizarMunicipios() {
            // Obtener el valor seleccionado de la provincia
            var provincia = document.getElementById("provincia").value;

            // Seleccionar el elemento del menú desplegable de municipios
            var municipioSelect = document.getElementById("municipio");

            // Limpiar las opciones actuales del menú desplegable de municipios
            municipioSelect.innerHTML = "";

            // Realizar una solicitud AJAX para obtener los municipios según la provincia seleccionada
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../../../shared/includes/obtener_municipios.php?provincia=" + provincia, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Parsear la respuesta JSON recibida del servidor
                    var municipios = JSON.parse(xhr.responseText);

                    // Iterar sobre cada municipio y agregarlo al menú desplegable de municipios
                    municipios.forEach(function (municipio) {
                        var option = document.createElement("option");
                        option.text = municipio.municipio_nombre;
                        option.value = municipio.municipio_id;
                        municipioSelect.add(option);

                        // Selecciona automáticamente el municipio correspondiente al valor del inmueble
                        if (municipio.municipio_nombre == "<?php echo $inmueble['inmueble_municipio']; ?>") {
                            option.selected = true;
                        }
                    });
                }
            };
            xhr.send(); // Enviar la solicitud AJAX al servidor
        }

        /********************************************************************************************************************************/

        window.addEventListener('message', function (event) {
            if (event.origin !== "http://localhost") {
                return;
            }
            if (event.data.imagesData) {
                console.log('Datos de imágenes recibidos:', event.data.imagesData);
                updateHiddenInput(event.data.imagesData);
            }
        }, false);

        function updateHiddenInput(imagesData) {
            const hiddenInput = document.getElementById('hiddenInput');
            hiddenInput.value = JSON.stringify(imagesData.map(image => ({
                name: image.name,
                data: image.data
            })));
        }
    </script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        /*
        var map; // Variable global para el mapa

        function generarMapa() {
            // Obtener los valores de los campos de dirección, provincia y municipio
            var direccion = document.getElementById('direccion').value;
            var provincia = document.getElementById('provincia').options[document.getElementById('provincia').selectedIndex].text;
            var municipio = document.getElementById('municipio').options[document.getElementById('municipio').selectedIndex].text;

            // Combinar la dirección, provincia y municipio para obtener una consulta completa
            var consulta = direccion + ', ' + municipio + ', ' + provincia;

            // Utilizar el servicio de geocodificación de OpenStreetMap Nominatim
            var url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(consulta);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        var latitud = parseFloat(data[0].lat);
                        var longitud = parseFloat(data[0].lon);

                        // Eliminar el mapa existente si existe
                        if (map) {
                            map.remove();
                        }

                        // Crear el mapa en el contenedor especificado
                        map = L.map('map').setView([latitud, longitud], 17);

                        // Agregar una capa de mapa base de OpenStreetMap
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);

                        // Añadir un marcador en las coordenadas obtenidas
                        L.marker([latitud, longitud]).addTo(map);
                    } else {
                        console.log('No se encontraron resultados para la dirección: ' + direccion);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los datos de geocodificación:', error);
                });
        } 
        */
    </script>
</body>

</html>