<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - NOVAMER INMOBILIARIA</title>
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
            height: 200px;
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
            width: 600px;
            height: 100%;
        }

        .container form {
            display: grid;
            grid-gap: 20px;
        }

        .container label {
            font-weight: bold;
        }

        .container input,
        .container textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .container textarea {
            height: 200px;
        }

        .container input[type="submit"] {
            background-color: #3b4876;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 14px 20px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .container input[type="submit"]:hover {
            background-color: #091a2b;
        }

        /* Media query para pantallas pequeñas */
        @media screen and (max-width: 600px) {
            .container {
                padding: 15px;
                width: calc(100% - 30px);
                /* Ajuste para compensar el relleno de 15px en cada lado */
            }

            .container form {
                grid-gap: 15px;
                width: 100%;
            }

            .container input,
            .container textarea {
                font-size: 14px;
                padding: 10px;
            }

            .container input[type="submit"] {
                padding: 12px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <?php include '../templates/navbar.php'; ?>

    <header class="banner">
        <h1>Contacto</h1>
    </header>

    <div class="container">

        <?php
        // Verifica si hay un mensaje enviado desde el script procesar_contacto.php
        if (isset($_GET['mensaje'])) {
            if ($_GET['mensaje'] === "enviado") {
                echo "<p style='color: green;'>¡Tu mensaje ha sido enviado correctamente!</p>";
            } elseif ($_GET['mensaje'] === "error") {
                echo "<p style='color: red;'>Lo siento, hubo un error al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.</p>";
            }
        }
        ?>

        <form action="../includes/procesar_contacto.php" method="post">

            <input type="hidden" id="id_inmueble" name="id_inmueble"
                value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">

            <label for="nombre">Nombre: *</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono">

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="4"></textarea>

            <input type="submit" value="Enviar">

        </form>

    </div>

    <?php include '../templates/footer.php'; ?>

</body>

</html>