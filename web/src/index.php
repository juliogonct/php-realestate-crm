<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            color: #333;
            margin-top: 35px;
            background-color: #f0f0f0;
        }

        header.banner {
            position: relative;
            width: 100%;
            height: 400px;
            background: linear-gradient(to right, #091a2b, #3b4876);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navigation {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .container1,
        .container2,
        .container3,
        .container4,
        .container5,
        .container6,
        .container7 {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 30px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .container1 {
            height: 100px;
        }

        .container2,
        .container3,
        .container4,
        .container6 {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .container2 .foto,
        .container3 .foto,
        .container4 .foto,
        .container6 .foto {
            flex: 0 0 100px;
            margin-right: 10px;
        }

        .container2 .foto img,
        .container3 .foto img,
        .container4 .foto img,
        .container6 .foto img {
            height: 250px;
            width: auto;
            border-radius: 10px;
            margin-left: 10px;
        }

        .container2 .texto,
        .container3 .texto,
        .container4 .texto,
        .container6 .texto {
            flex: 1;
            padding: 20px;
            text-align: justify;
        }

        .mas-informacion-button {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .mas-informacion-button:hover {
            background-color: #555;
        }

        .container5 {
            height: 100px;
        }

        .container7 {
            height: 150px;
        }

        @media screen and (max-width: 768px) {

            .container2,
            .container3,
            .container4,
            .container6 {
                flex-direction: column;
                align-items: flex-start;
            }

            .container2 .foto,
            .container3 .foto,
            .container4 .foto,
            .container6 .foto {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
                text-align: center;
            }

            .container2 .foto img,
            .container3 .foto img,
            .container4 .foto img,
            .container6 .foto img {
                width: 100%;
                height: auto;
                margin-left: 0;
                border-radius: 8px;
            }

            .container2 .texto,
            .container3 .texto,
            .container4 .texto,
            .container6 .texto {
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    <?php include '../templates/navbar.php'; ?>

    <div class="container">

        <header class="banner">
            <?php include 'filtro_basico.php'; ?>
        </header>

        <nav class="navigation"></nav>

        <div class="container1"></div>

        <!-- ======================================================================================================================== -->

        <div class="container2">
            <div class="texto">

                <h2>Quiénes somos</h2>

                NOVAMER INMOBILIARIA desarrolla su labor de intermediación inmobiliaria desde 1997.

                <br><br>

                Nos hemos especializado en la gestión de compra-ventas, nuevas promociones y alquileres de inmuebles.
                Con 27 años de experiencia profesional, operamos en toda la Comarca de Cartagena, incluyendo áreas
                residenciales y zonas de playa.

                <br><br>

                Nuestro compromiso es el de ofrecer un servicio personalizado y de calidad, adaptado a las
                necesidades de cada cliente.

                <br><br>

                <button class="mas-informacion-button">Más Información</button>

            </div>

            <div class="foto"><img src="../../shared/images/venta.jpg" alt="Logo"></div>

        </div>

        <!-- ======================================================================================================================== -->

        <div class="container3">

            <div class="foto"><img src="../../shared/images/encargo.jpeg" alt="Logo"></div>

            <div class="texto">

                <h2>Servicios</h2>

                En NOVAMER INMOBILIARIA, ofrecemos asesoramiento integral en compra, venta y alquiler de inmuebles, así
                como en la comercialización de nuevas promociones.

                <br><br>

                También realizamos tasaciones precisas para determinar el valor de su propiedad. Nuestro enfoque
                personalizado asegura que cada cliente reciba atención y soluciones a medida para satisfacer sus
                necesidades inmobiliarias.

                <br><br>

            </div>
        </div>

        <!-- ======================================================================================================================== -->

        <div class="container4">

            <div class="texto">

                <h2>Encargo de venta</h2>

                Confíenos la compra, venta o alquiler de su inmueble. Complete nuestro sencillo formulario de encargo y
                comenzaremos a gestionar su solicitud de inmediato. Nos encargamos de todo, desde la promoción hasta la
                negociación, garantizando un proceso ágil y seguro. Su tranquilidad es nuestra prioridad.

                <br><br>

                <button class="mas-informacion-button">Más Información</button>

            </div>

            <div class="foto"><img src="../../shared/images/bg.png" alt="Logo"></div>

        </div>

        <!-- ======================================================================================================================== -->

        <div class="container5"></div>

        <!-- ======================================================================================================================== -->

        <div class="container6">

            <div class="foto"><img src="../../shared/images/logo.jpg" alt="Logo"></div>

            <div class="texto">

                Etiam non quam lacus suspendisse faucibus interdum posuere. Sed vulputate mi sit amet mauris commodo
                quis imperdiet massa. Molestie at elementum eu facilisis sed. Dignissim convallis aenean et tortor.
                Convallis a cras semper auctor. Ac turpis egestas integer eget aliquet nibh. Elit eget gravida cum
                sociis. Ut placerat orci nulla pellentesque. Quam elementum pulvinar etiam non quam. Id aliquet risus
                feugiat in.

                <br><br>

                <button class="mas-informacion-button">Más Información</button>

            </div>
        </div>

        <!-- ======================================================================================================================== -->

        <div class="container7"></div>

    </div>

    <?php include '../templates/footer.php'; ?>
</body>

</html>