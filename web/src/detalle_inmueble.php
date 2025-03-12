<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css">
    <title>Detalles del Inmueble</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            max-width: 100%;
        }

        .contenido {
            max-width: 900px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* ======================================================================================================================== */

        .detalle-inmueble p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 0.5em;
        }

        /* ======================================================================================================================== */

        .caracteristicas-container {
            display: flex;
            justify-content: space-around;
        }

        .caracteristicas-column {
            text-align: center;
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 1em;
            width: 150px;
            height: 150px;
            background-color: #091a2b;
        }

        .caracteristicas-column img {
            width: 85px;
        }

        .caracteristicas-column p {
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        /* ======================================================================================================================== */

        .descripcion {
            color: black;
            font-size: 19px;
            line-height: 1.6;
            margin-bottom: 0.5em;
            padding: 1em;
            border: 1px solid #ddd;
            border-radius: 12px;
            background-color: white;
            text-align: justify;
            font-family: Arial, sans-serif;
        }

        #botonLeerMas {
            background-color: #091a2b;
            color: white;
            border: 1px solid #091a2b;
            border-radius: 5px;
            /* Borde redondeado */
            padding: 5px 10px;
            cursor: pointer;
        }

        /* ======================================================================================================================== */

        .cualidades-container {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
            justify-content: center;
            align-items: start;
            padding: 20px;
        }

        .cualidades-column {
            border: 2px solid #091a2b;
            border-radius: 12px;
            padding: 10px;
            background-color: white;
            font-size: 19px;
            text-align: center;
            margin-bottom: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-height: 140px;
            width: 110px;
            height: 150px;
        }

        .cualidades-column img {
            width: 50px;
            height: auto;
            margin-top: 10px;
            margin-bottom: 1px;
        }

        /* ======================================================================================================================== */

        .rasgos-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .rasgos-column {
            display: inline-block;
            border-radius: 12px;
            background-color: #091a2b;
            color: white;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
            padding: 0 10px;
            padding-bottom: 8px;
            margin: 5px;
        }

        /* ======================================================================================================================== */

        #map {
            height: 600px;
        }

        /* ======================================================================================================================== */

        @media (max-width: 900px) {

            .contenido {
                max-width: 100%;
            }

            .caracteristicas-container {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 7px;
                justify-content: center;
                align-items: center;
                padding: 10px;
                max-width: 100%;
                overflow: auto;
            }

            .caracteristicas-column {
                text-align: center;
                border: 1px solid transparent;
                border-radius: 10px;
                background-color: #091a2b;
                max-width: 80%;
            }

            .cualidades-container {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 10px;
                justify-content: center;
                align-items: center;
                max-width: 100%;
                overflow: auto;
                padding: 1px;
            }

            .cualidades-column {
                border: 2px solid #091a2b;
                border-radius: 8px;
                background-color: white;
                font-size: 12px;
                text-align: center;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                max-width: 80%;
            }

            .cualidades-column img {
                width: 40px;
                height: auto;
                margin-top: 5px;
                margin-bottom: 3px;
            }

            .cualidades-column div {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100%;
            }

            #map {
                height: 300px;
            }
        }
    </style>
</head>

<body>

    <?php include '../templates/navbar.php'; ?><br><br><br><br><br>

    <div class="contenido">
        <div class="detalle-inmueble">
            <?php
            // Incluir el archivo de conexión
            include '../../shared/includes/obtener_conexion.php';

            // Obtener el ID del inmueble de la URL
            $inmueble_id = $_GET['id'];

            // Consulta SQL para seleccionar el inmueble con el ID especificado y sus extras
            $sql = "SELECT i.*, e.* FROM inmuebles AS i LEFT JOIN extras AS e ON i.inmueble_id = e.inmueble_id WHERE i.inmueble_id = $inmueble_id";
            $resultado = $conexion->query($sql);

            // Comprobar si hay resultados
            if ($resultado->num_rows > 0) {
                // Mostrar los detalles del inmueble
                $inmueble = $resultado->fetch_assoc();

                // ========================================================================================================================
            
                // Incluir el código para mostrar la galería de imágenes (https://www.w3schools.com/howto/howto_js_slideshow_gallery.asp)
                include 'detalle_immieble_imagen.php';

                // ========================================================================================================================
            
                // Mostrar precio
                echo "<p>" . $inmueble['inmueble_precio'] . " €</p>";

                // Mostrar dirección
                echo "<p>" . $inmueble['inmueble_dir'] . "</p><br>";

                // ========================================================================================================================
            
                // Mostrar características del inmueble (habitaciones, baños, superficie, estado)
            
                echo "<div class='caracteristicas-container'>";

                $caracteristicas = array(
                    array("icono" => "cama2.webp", "nombre" => "habitación", "valor" => $inmueble['inmueble_habitaciones']),
                    array("icono" => "bano.webp", "nombre" => "baño", "valor" => $inmueble['inmueble_banos']),
                    array("icono" => "superficie.webp", "nombre" => "m²", "valor" => $inmueble['inmueble_superficie']),
                    array("icono" => "estado.webp", "nombre" => "", "valor" => $inmueble['inmueble_estado'])
                );

                foreach ($caracteristicas as $caracteristica) {
                    echo "<div class='caracteristicas-column'>";
                    echo "<img src='../../shared/images/iconos/inmueble/" . $caracteristica['icono'] . "' alt='" . $caracteristica['nombre'] . "' class='icon'>";

                    // Ajustar el nombre de la característica según el valor (singular o plural)
            
                    if ($caracteristica['nombre'] == "habitación") {
                        $nombre = $caracteristica['valor'] == 1 ? $caracteristica['nombre'] : "habitaciones";
                    } elseif ($caracteristica['nombre'] == "baño") {
                        $nombre = $caracteristica['valor'] == 1 ? $caracteristica['nombre'] : "baños";
                    } else {
                        $nombre = $caracteristica['nombre'];
                    }
                    echo "<p>" . $caracteristica['valor'] . " " . $nombre . "</p>";
                    echo "</div>";
                }

                echo "</div><br><br>";

                // ========================================================================================================================
            
                // Mostrar descripción del inmueble (completa con opción para leer más)
            
                $descripcion = nl2br($inmueble['inmueble_descripcion']);
                $descripcionCorta = substr($descripcion, 0, 300) . (strlen($descripcion) > 300 ? "..." : "");

                $descripcionCompleta = $descripcionCorta . "<span id='restoDescripcion' style='display:none;'>" . substr($descripcion, 100) . "</span>";

                echo "<div class='descripcion' id='descripcionCompleta'>" . $descripcionCompleta . "</div>";
                echo "<button onclick='mostrarMas()' id='botonLeerMas'>Leer más...</button><br><br>";

                // ========================================================================================================================
            
                // Mostrar cualidades del inmueble (tipo de contrato, orientación, antigüedad, certificado energético, amueblado, ascensor)
            
                $cualidades = array(
                    array("icono" => "contrato.svg", "dato" => $inmueble['inmueble_tipo_contrato'] ? "<b>Contrato</b> <br>" . $inmueble['inmueble_tipo_contrato'] : ""),
                    array("icono" => "orientacion.svg", "dato" => $inmueble['inmueble_orientacion'] ? "<b>Orientación</b> <br>" . $inmueble['inmueble_orientacion'] : ""),
                    array("icono" => "reloj.svg", "dato" => $inmueble['inmueble_antiguedad'] ? "<b>Antigüedad</b> <br>" . $inmueble['inmueble_antiguedad'] : ""),
                    array("icono" => "energetico.svg", "dato" => $inmueble['inmueble_certificado'] ? "<b>Certificado</b> <br>" . $inmueble['inmueble_certificado'] : ""),
                    array("icono" => "mueble.svg", "dato" => $inmueble['extra_amueblado'] ? "Amueblado" : "No <br> amueblado"),
                    array("icono" => "mueble.svg", "dato" => $inmueble['extra_ascensor'] ? "Ascensor" : "Sin <br> ascensor"),
                );

                // Mostrar cualidades en una fila con cada dato debajo de su respectiva foto y su título
                echo "<div class='cualidades-container'>";
                foreach ($cualidades as $cualidad) {
                    echo "<div class='cualidades-column'>";
                    echo "<img src='../../shared/images/iconos/inmueble/" . $cualidad['icono'] . "' alt='Dato' class='icon'>";

                    echo "<p>" . $cualidad['dato'] . "</p>";
                    echo "</div>";
                }
                echo "</div>";

                // ========================================================================================================================
            
                // Mostrar rasgos del inmueble (extras)
            
                $rasgos = array();

                foreach ($inmueble as $clave => $valor) {

                    if ($clave === 'inmueble_id' || $clave === 'extra_id' || $clave === 'extra_amueblado' || $clave === 'extra_ascensor') {
                        continue;
                    }

                    // Verificar si la clave comienza con "extra_" para identificar los extras
                    if (strpos($clave, 'extra_') === 0 && $valor) {
                        // Eliminar "extra_" de la clave para obtener el nombre a mostrar del rasgo
                        $nombre_rasgo = ucfirst(str_replace('_', ' ', str_replace('extra_', '', $clave)));
                        // Agregar el rasgo al array
                        $rasgos[] = ucfirst($nombre_rasgo); // Primera letra en mayúscula
                    }
                }

                // Mostrar rasgos en una tabla 
                echo "<div class='rasgos-container'>";
                foreach ($rasgos as $rasgo) {
                    echo "<div class='rasgos-column'>";
                    echo "<p>" . $rasgo . "</p>";
                    echo "</div>";
                }
                echo "</div><br>";

                // ========================================================================================================================
            
            } else {
                echo "<p>No se encontró el inmueble.</p>";
            }

            $conexion->close();
            ?>

            <!-- Mostrar mapa con la ubicación del inmueble -->
            <div id="map"></div>

        </div>
    </div>

    <?php include '../templates/footer.php'; ?>

    <script>
        // Scripts para la galería de imágenes (detalle_immieble_imagen.php)
        var currentIndex = 0;
        var imagenes = <?php echo json_encode($imagenes_inmueble); ?>;

        function cambiarImagen(delta) {
            currentIndex += delta;

            // Asegurarse de que currentIndex esté dentro de los límites
            if (currentIndex < 0) {
                currentIndex = imagenes.length - 1;
            } else if (currentIndex >= imagenes.length) {
                currentIndex = 0;
            }

            // Cambiar la imagen mostrada
            document.getElementById('current-image').src = imagenes[currentIndex];
        }
    </script>

    <script>
        // Script para mostrar/ocultar la descripción completa del inmueble
        function mostrarMas() {
            var descripcionCompleta = document.getElementById("descripcionCompleta");
            var restoDescripcion = document.getElementById("restoDescripcion");
            var boton = document.getElementById("botonLeerMas");

            if (restoDescripcion.style.display === "none") {
                restoDescripcion.style.display = "inline";
                boton.innerHTML = "Leer menos";
                // Eliminar puntos suspensivos al mostrar la descripción completa
                descripcionCompleta.innerHTML = descripcionCompleta.innerHTML.replace("...", "");
            } else {
                restoDescripcion.style.display = "none";
                boton.innerHTML = "Leer más...";
                // Agregar puntos suspensivos al mostrar la descripción corta
                if (descripcionCompleta.innerHTML.length > 300) {
                    descripcionCompleta.innerHTML += "...";
                }
            }
        }
    </script>

    <script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js"></script>
    <script>
        // Script para cargar el mapa de OpenStreetMap con la ubicación del inmueble (https://stackoverflow.com/questions/52185748/using-leaflet-map-in-php-page)
        var map = L.map('map').setView([0, 0], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Dirección obtenida desde PHP
        var direccion = "<?php echo $inmueble['inmueble_dir'] . ', ' . $inmueble['inmueble_municipio'] . ', ' . $inmueble['inmueble_provincia']; ?>";

        // Utiliza el servicio de geocodificación de OpenStreetMap Nominatim
        var url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(direccion);
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Verificar si se encontraron resultados
                if (data && data.length > 0) {
                    var latitud = parseFloat(data[0].lat);
                    var longitud = parseFloat(data[0].lon);

                    // Añadir un marcador en las coordenadas obtenidas
                    L.marker([latitud, longitud]).addTo(map);

                    // Centrar el mapa en las coordenadas del marcador
                    map.setView([latitud, longitud], 17);
                } else {
                    console.log('No se encontraron resultados para la dirección: ' + direccion);
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos de geocodificación:', error);
            });
    </script>
</body>

</html>