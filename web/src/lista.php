<style>
    .lista-inmuebles {
        flex: 1;
        padding: 20px;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow-y: auto;
    }

    .inmueble:hover {
        transform: scale(1.01);
    }

    .inmueble {
        display: flex;
        margin-bottom: 20px;
        background-color: #fff;
        align-items: center;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: width 0.3s ease, transform 0.2s ease;
    }

    .inmueble img {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        width: 275px;
        height: 200px;
        object-fit: cover;
        padding-right: 20px;
    }

    .inmueble-details {
        padding: 10px;
        flex-grow: 1;
    }

    .inmueble-price {
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .inmueble-info {
        font-size: 14px;
        color: #666;
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .inmueble-desc {
        font-size: 14px;
        color: #666;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /*Número de líneas*/
        -webkit-box-orient: vertical;
    }
</style>

<div class="lista-inmuebles">
    <?php
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            // Obtener la lista de imágenes dentro de la carpeta del inmueble
            $carpeta_imagenes_inmueble = '../../shared/images/inmuebles/' . $fila['inmueble_id'] . '/';
            $imagenes_inmueble = glob($carpeta_imagenes_inmueble . '*.{jpg,jpeg,png,gif,svg,webp}', GLOB_BRACE);

            // Comenzar el contenedor de inmueble
            echo "<div class='inmueble'>";

            // Mostrar la primera imagen del inmueble si existe o una imagen por defecto
            echo "<a href='detalle_inmueble.php?id=" . $fila['inmueble_id'] . "'>";
            if (!empty($imagenes_inmueble)) {
                echo "<img src='" . $imagenes_inmueble[0] . "' alt='Foto del inmueble'>";
            } else {
                echo "<img src='../../shared/images/logo.jpg' alt='Foto del inmueble'>";
            }
            echo "</a>";

            // Detalles del inmueble
            echo "<div class='inmueble-details'>";
            echo "<div class='inmueble-price'>" . $fila['inmueble_precio'] . "€</div>";

            if ($fila['inmueble_tipo_inmueble'] === 'Vivienda') {
                echo "<p class='tipo-vivienda'>" . $fila['inmueble_tipo_vivienda'] . " en " . $fila['inmueble_dir'] . "</p>";
            } else {
                echo "<p class='tipo-inmueble'>" . $fila['inmueble_tipo_inmueble'] . " en " . $fila['inmueble_dir'] . "</p>";
            }

            echo "<p>" . $fila['inmueble_habitaciones'] . " habs. | " . $fila['inmueble_banos'] . " baños | " . $fila['inmueble_superficie'] . "m²</p>";

            echo "<p class='inmueble-desc'>" . $fila['inmueble_descripcion'] . "</p>";

            echo "</div>";
            echo "</div>";
    
        }
    } else {
        echo "<p>No se encontraron inmuebles.</p>";
    }
    ?>
</div>