<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - NOVAMER INMOBILIARIA</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f0f0f0;
            height: 100%;
        }

        header.banner {
            margin-top: 85px;
            position: relative;
            width: 100%;
            height: 170px;
            background: linear-gradient(to right, #091a2b, #3b4876);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 30px;
            margin: 0 auto;
            max-width: 1000px;
            height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .container p {
            text-align: justify;
            line-height: 1.6;
        }

        /* Media query para pantallas pequeñas */
        @media screen and (max-width: 600px) {
            header.banner {
                height: 100px;
            }

            .container {
                padding: 30px;
                width: calc(100% - 60px);
                /* Ajuste para compensar el relleno de 15px en cada lado */
            }
        }
    </style>
</head>

<body>

    <?php include '../templates/navbar.php'; ?>

    <header class="banner">
        <h1>Sobre Nosotros</h1>
    </header>

    <div class="container">
        <p>
            Bienvenido a NOVAMER INMOBILIARIA, donde convertimos tus sueños de hogar en realidad. Con una trayectoria
            de más de dos décadas en el mercado inmobiliario, hemos establecido un estándar de excelencia en el
            asesoramiento personalizado para la compra, venta y alquiler de propiedades.
        </p>
        <p>
            En NOVAMER, no solo vendemos casas; creamos hogares. Nos enorgullece ofrecer un servicio integral que va
            más allá de cerrar transacciones. Nos esforzamos por comprender las necesidades únicas de cada cliente y
            proporcionar soluciones a medida que cumplan y superen sus expectativas.
        </p>
        <p>
            Nuestro equipo de profesionales altamente capacitados está dedicado a brindar un servicio excepcional en
            todas las etapas del proceso inmobiliario. Desde la primera consulta hasta la entrega de llaves, estamos
            aquí para guiarlo y apoyarlo en cada paso del camino.
        </p>
        <p>
            Si está buscando comprar, vender o alquilar una propiedad,
            ¡no dude en ponerse en contacto con nosotros! Estamos aquí para ayudarle a alcanzar
            sus metas inmobiliarias con confianza y tranquilidad.
        </p>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>

</html>