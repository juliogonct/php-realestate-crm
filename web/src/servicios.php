<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - NOVAMER INMOBILIARIA</title>
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
            max-width: 800px;
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
        <h1>Nuestros Servicios</h1>
    </header>

    <div class="container">
        <p>
            En NOVAMER INMOBILIARIA, ofrecemos una amplia gama de servicios inmobiliarias para satisfacer todas tus
            necesidades:
        </p>
        <ul>
            <li>Asesoramiento integral en compra, venta y alquiler de propiedades.</li>
            <li>Comercialización de nuevas promociones y proyectos inmobiliarios.</li>
            <li>Tasaciones precisas para determinar el valor de tu propiedad.</li>
            <li>Encargo de venta: gestionamos todo el proceso de venta desde la promoción hasta la negociación.</li>
            <li>Asesoramiento legal y financiero para garantizar transacciones seguras y exitosas.</li>
            <li>Atención personalizada y soluciones a medida para satisfacer tus necesidades específicas.</li>
        </ul>
        <p>
            Nuestro objetivo es proporcionarte un servicio de alta calidad y orientado a resultados, para que puedas
            tomar decisiones informadas y alcanzar tus objetivos inmobiliarios con confianza.
        </p>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>

</html>