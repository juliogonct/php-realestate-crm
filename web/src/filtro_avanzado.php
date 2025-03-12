<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .left-panel {
            display: flex;
            flex-direction: column;
        }

        .filtro-panel {
            flex-basis: 300px;
            height: 100%;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .filtro-panel select,
        .filtro-panel input[type="text"],
        .filtro-panel input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .filtro-panel select {
            cursor: pointer;
        }

        .filtro-panel button {
            background-color: #091a2b;
        }

        /* ======================================================================================================================== */

        /* Contenedor general de los extras */
        .extras-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        /* Estilo base para los botones, usando solo la etiqueta para todo */
        .extra label {
            cursor: pointer;
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            background-color: #f8f8f8;
            color: #333;
            border: 1px solid #ccc;
            text-decoration: none;
            /* Asegura que no haya subrayado */
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
    </style>
</head>

<body>

    <div class="left-panel">
        <div class="filtro-panel">
            <form action="../includes/procesar_busqueda.php" method="POST">

                <label for="inmueble_tipo_contrato">Tipo de Contrato:</label>
                <select name="inmueble_tipo_contrato" id="inmueble_tipo_contrato" placeholder="Tipo de Contrato">
                    <option value="" disabled selected> -- Escoja una opción -- </option>
                    <option value="Venta">Venta</option>
                    <option value="Alquiler">Alquiler</option>
                    <option value="Compartir">Compartir</option>
                </select><br><br>

                <!-- ======================================================================================================================== -->

                <label for="inmueble_tipo_inmueble">Tipo de Inmueble:</label>
                <select name="inmueble_tipo_inmueble" id="inmueble_tipo_inmueble" placeholder="Tipo de Inmueble"
                    onchange="habilitarTipoVivienda()">
                    <option value="" disabled selected> -- Escoja una opción -- </option>
                    <option value="Vivienda">Vivienda</option>
                    <option value="Garaje">Garaje</option>
                    <option value="Terreno">Terreno</option>
                    <option value="Local">Local</option>
                    <option value="Oficina">Oficina</option>
                    <option value="Trastero">Trastero</option>
                </select><br><br>

                <!-- ======================================================================================================================== -->

                <label for="inmueble_tipo_vivienda">Tipo de Vivienda:</label>
                <select name="inmueble_tipo_vivienda" id="inmueble_tipo_vivienda" placeholder="Tipo de Vivienda">
                    <option value="" disabled selected> -- Escoja una opción -- </option>
                    <option value="Piso">Piso</option>
                    <option value="Apartamento">Apartamento</option>
                    <option value="Ático">Ático</option>
                    <option value="Dúplex">Dúplex</option>
                    <option value="Estudio">Estudio</option>
                    <option value="Loft">Loft</option>
                    <option value="Chalet">Chalet</option>
                    <option value="Planta baja">Planta baja</option>
                    <option value="Finca rústica">Finca rústica</option>
                    <option value="Casa adosada">Casa adosada</option>
                </select><br><br>

                <!-- ======================================================================================================================== -->

                <label for="inmueble_precio">Precio (Máximo):</label>
                <input type="number" name="inmueble_precio" id="inmueble_precio"><br><br>

                <label for="inmueble_habitaciones">Habitaciones (Mínimo):</label>
                <input type="number" name="inmueble_habitaciones" id="inmueble_habitaciones"><br><br>

                <label for="inmueble_banos">Baños (Mínimo):</label>
                <input type="number" name="inmueble_banos" id="inmueble_banos"><br><br>

                <label for="inmueble_superficie">Superficie (Mínimo):</label>
                <input type="number" name="inmueble_superficie" id="inmueble_superficie"><br><br>

                <!-- ======================================================================================================================== -->

                <!-- <span>Extras:</span>
                <div class="extras-container">
                    <?php
                    // Lista de extras
                /*  $extras = array(
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
                        "Terraza",
                        "Trastero",
                        "Videoportero",
                        "Zona Comunitaria",
                        "Zona Deportiva",
                        "Zona Infantil"
                    );

                    // Generar los checkboxes y etiquetas para cada extra
                    foreach ($extras as $extra) {

                        // Convertir el nombre del extra a un formato válido para el atributo "name" del checkbox
                        $extraName = strtolower(str_replace(["á", "é", "í", "ó", "ú", "ñ", " "], ["a", "e", "i", "o", "u", "n", "_"], $extra));

                        echo '<div class="extra">';
                        echo '<input type="checkbox" id="' . $extraName . '" name="extra_[' . $extraName . ']">';
                        echo '<label for="' . $extraName . '">' . $extra . '</label>';
                        echo '</div>';
                    }
                */
                    ?>
                </div><br><br>-->

                <!-- ======================================================================================================================== -->

                <label for="inmueble_orientacion">Orientación:</label>
                <select name="inmueble_orientacion" id="inmueble_orientacion">
                    <option value=""> -- Escoja una opción -- </option>
                    <option value="Norte">Norte</option>
                    <option value="Noreste">Noreste</option>
                    <option value="Noroeste">Noroeste</option>
                    <option value="Sur">Sur</option>
                    <option value="Sureste">Sureste</option>
                    <option value="Suroeste">Suroeste</option>
                    <option value="Este">Este</option>
                    <option value="Oeste">Oeste</option>
                </select><br><br>

                <!-- ======================================================================================================================== -->

                <label for="inmueble_estado">Estado:</label>
                <select name="inmueble_estado" id="inmueble_estado">
                    <option value=""> -- Escoja una opción -- </option>
                    <option value="Nuevo">Nuevo</option>
                    <option value="Casi nuevo">Casi nuevo</option>
                    <option value="Buen estado">Buen estado</option>
                    <option value="Reformado">Reformado</option>
                    <option value="A reformar">A reformar</option>
                </select><br><br>

                <!-- ======================================================================================================================== -->

                <label for="inmueble_antiguedad">Antigüedad:</label>
                <select name="inmueble_antiguedad" id="inmueble_antiguedad">
                    <option value=""> -- Escoja una opción -- </option>
                    <option value="0 a 1 año">Menos de 1 año</option>
                    <option value="1 a 5 años">1 a 5 años</option>
                    <option value="5 a 10 años">5 a 10 años</option>
                    <option value="10 a 20 años">10 a 20 años</option>
                    <option value="20 a 30 años">20 a 30 años</option>
                    <option value="30 a 50 años">30 a 50 años</option>
                    <option value="50 a 70 años">50 a 70 años</option>
                    <option value="70 a 100 años">70 a 100 años</option>
                    <option value="100 años o más">+100 años</option>
                </select><br><br>

                <!-- ======================================================================================================================== -->

                <label for="inmueble_certificado">Certificado Energético:</label>
                <select name="inmueble_certificado" id="inmueble_certificado">
                    <option value=""> -- Escoja una opción -- </option>
                    <option value="Tramitándose">Tramitándose</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                    <option value="G">G</option>
                </select><br><br>

                <button type="submit">Buscar</button>
            </form>
        </div>
    </div>

</body>

<script>
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
</script>

</html>