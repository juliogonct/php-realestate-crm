<style>
    .grid-container {
        flex: 1;
        padding: 10px;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow-y: auto;
    }

    .inmueble {
        border-radius: 10px;
        padding: 1em;
        margin: 1em;
        float: left;
        box-sizing: border-box;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: calc(50% - 2em);
        transition: width 0.3s ease, transform 0.2s ease;
        position: relative;
    }

    .inmueble img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.1s ease;
    }

    .inmueble:hover {
        transform: scale(1.02);
    }

    .inmueble p {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    /* ======================================================================================================================== */

    .precio {
        font-size: 24px;
    }

    .tipo-direccion {
        font-size: 16px;
    }

    .detalles-adicionales {
        font-size: 12px;
    }

    /* ======================================================================================================================== */

    /* Ajustes para pantallas de todos los tamaños */

    /* Ajustes para móviles */
    @media (max-width: 1101px) {
        .inmueble {
            width: calc(100% - 2em);
            /* Un cuadro por fila en móviles */
            margin-right: 1;
            margin-left: 1;
        }
    }

    @media (min-width: 1100px) {
        .inmueble {
            width: calc(50% - 2em);
            /* Tres cuadros por fila en pantallas grandes */
        }
    }

    @media screen and (min-width: 1450px) {
        .inmueble {
            width: calc(33.33% - 20px);
            /* Tres columnas por fila */
            margin: 10px;
        }
    }

    @media screen and (min-width: 1900px) {
        .inmueble {
            width: calc(25% - 20px);
            /* Cuatro columnas por fila */
            margin: 10px;
        }
    }

    @media screen and (min-width: 2500px) {
        .inmueble {
            width: calc(20% - 20px);
            /* Cinco columnas por fila */
            margin: 10px;
        }
    }

    @media screen and (min-width: 3000px) {
        .inmueble {
            width: calc(16.666% - 20px);
            /* Seis columnas por fila */
            margin: 10px;
        }
    }

    @media screen and (min-width: 3500px) {
        .inmueble {
            width: calc(14.2857% - 20px);
            /* Siete columnas por fila */
            margin: 10px;
        }
    }

    @media screen and (min-width: 4000px) {
        .inmueble {
            width: calc(12.5% - 20px);
            /* Ocho columnas por fila */
            margin: 10px;
        }
    }

    @media screen and (min-width: 5000px) {
        .inmueble {
            width: calc(10% - 20px);
            /* Diez columnas por fila */
            margin: 10px;
        }
    }
</style>

<div class="grid-container">

    <?php
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<div class='inmueble'>";

            // Obtener la lista de imágenes dentro de la carpeta del inmueble
            $carpeta_imagenes_inmueble = '../../shared/images/inmuebles/' . $fila['inmueble_id'] . '/';
            $imagenes_inmueble = glob($carpeta_imagenes_inmueble . '*.{jpg,jpeg,png,gif,svg,webp}', GLOB_BRACE);

            // Mostrar la primera imagen del inmueble si existe
            echo "<a href='detalle_inmueble.php?id=" . $fila['inmueble_id'] . "'>";
            if (!empty($imagenes_inmueble)) {
                echo "<img src='" . $imagenes_inmueble[0] . "' alt='Foto del inmueble'>";
            } else {
                echo "<img src='../../shared/images/logo.jpg' alt='Foto del inmueble'>";
            }
            echo "</a>";

            echo "<div class='campo precio' style='font-size: 24px;'>";
            echo "<p>" . $fila['inmueble_precio'] . "€</p>";
            echo "</div>";

            echo "<div class='campo tipo-direccion' style='font-size: 18px;'>";
            // Verificar si el tipo de inmueble es 'Vivienda'
            if ($fila['inmueble_tipo_inmueble'] === 'Vivienda') {
                echo "<p class='tipo-vivienda'>" . $fila['inmueble_tipo_vivienda'] . " en " . $fila['inmueble_dir'] . "</p>";
            } else {
                echo "<p class='tipo-inmueble'>" . $fila['inmueble_tipo_inmueble'] . " en " . $fila['inmueble_dir'] . "</p>";
            }
            echo "</div>";

            echo "<div class='campo detalles-adicionales' style='font-size: 20px;'>";
            echo "<p>" . $fila['inmueble_habitaciones'] . " habs. | " . $fila['inmueble_banos'] . " baños | " . $fila['inmueble_superficie'] . "m²</p>";
            echo "</div>";

            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron inmuebles.</p>";
    }

    // Limpiar la consulta de la sesión si ya no se necesita
    unset($_SESSION['consulta']);

    $conexion->close();
    ?>

</div>