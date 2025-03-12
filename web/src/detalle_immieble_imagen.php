<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        img {
            vertical-align: middle;
        }

        /* Position the image container (needed to position the left and right arrows) */
        .container {
            position: relative;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Add a pointer when hovering over the thumbnail images */
        .cursor {
            cursor: pointer;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 47%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 14px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Six columns side by side */
        .column {
            float: left;
            width: 16.66%;
            overflow: hidden;
            padding-top: 12%;
            /* Relación de aspecto de 4:3 */
            position: relative;
        }

        /* Ajusta el tamaño de las miniaturas */
        .column img {
            min-width: 100%;
            min-height: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Ajustes para la imagen principal */
        .main-img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /* Transparencia para imagenes secundarias */
        .demo {
            opacity: 0.6;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }
    </style>
</head>

<body>

    <div class="detalle-inmueble">
        <?php

        // Consulta SQL para seleccionar el inmueble con el ID especificado y sus extras
        $sql = "SELECT i.*, e.* FROM inmuebles AS i LEFT JOIN extras AS e ON i.inmueble_id = e.inmueble_id WHERE i.inmueble_id = $inmueble_id";
        $resultado = $conexion->query($sql);

        // Verifica si la consulta SQL encontró algún registro para el inmueble con el ID especificado.
        if ($resultado->num_rows > 0) {
            // Si se encontró el inmueble, se procede a mostrar sus detalles.
            $inmueble = $resultado->fetch_assoc();

            // ========================================================================================================================
        
            // Define la ruta completa de la carpeta donde se almacenan las imágenes del inmueble actual.
            $carpeta_imagenes_inmueble = '../../shared/images/inmuebles/' . $inmueble_id . '/';

            // Obtener la lista de imágenes dentro de la carpeta del inmueble
            $imagenes_inmueble = glob($carpeta_imagenes_inmueble . '*.{jpg,jpeg,png,gif,svg,webp}', GLOB_BRACE);

            // Comprobar si se encontraron imágenes
            if (empty($imagenes_inmueble)) {
                // Si no hay imágenes para el inmueble, se muestra una imagen por defecto en su lugar.
                $imagen_por_defecto = '../../shared/images/logo.jpg';
                $imagenes_inmueble = [$imagen_por_defecto];
            }
            ?>

            <div class="container">
                <?php
                // Recorrer las imágenes del inmueble y mostrarlas en un slider
                foreach ($imagenes_inmueble as $key => $imagen) {
                    $numero_imagen = $key + 1;
                    ?>
                    <div class="mySlides">
                        <div class="numbertext"><?php echo $numero_imagen . ' / ' . count($imagenes_inmueble); ?></div>
                        <img src="<?php echo $imagen; ?>" style="width:100%" class="main-img">
                    </div>
                    <?php
                }
                ?>

                <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a>

                <div class="row">
                    <?php
                    // Mostrar miniaturas de las imágenes para la navegación
                    foreach ($imagenes_inmueble as $key => $imagen) {
                        $numero_imagen = $key + 1;
                        ?>
                        <div class="column">
                            <img class="demo cursor" src="<?php echo $imagen; ?>" style="width:100%"
                                onclick="currentSlide(<?php echo $numero_imagen; ?>)" alt="<?php echo basename($imagen); ?>">
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <script>

                // Este JavaScript para controlar el slider de imágenes, incluyendo la navegación entre imágenes y la visualización de miniaturas.

                let slideIndex = 1;
                showSlides(slideIndex);

                function plusSlides(n) {
                    showSlides(slideIndex += n);
                }

                function currentSlide(n) {
                    showSlides(slideIndex = n);
                }

                function showSlides(n) {
                    let i;
                    let slides = document.getElementsByClassName("mySlides");
                    let dots = document.getElementsByClassName("demo");
                    let captionText = document.getElementById("caption");
                    if (n > slides.length) { slideIndex = 1 }
                    if (n < 1) { slideIndex = slides.length }
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    for (i = 0; i < dots.length; i++) {
                        dots[i].className = dots[i].className.replace(" active", "");
                    }
                    slides[slideIndex - 1].style.display = "block";
                    dots[slideIndex - 1].className += " active";
                    captionText.innerHTML = dots[slideIndex - 1].alt;
                }
            </script>

            <?php
        } else {
            echo "No se encontraron detalles para este inmueble.";
        }
        ?>
    </div>


    <!-- https://www.w3schools.com/howto/howto_js_slideshow_gallery.asp -->

</body>

</html>