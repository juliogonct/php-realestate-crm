<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Barra Superior - Gestión Inmobiliaria</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body,
        html {
            font-family: 'Montserrat', sans-serif;
            background-color: #fdfdfd;
        }

        .navbar {
            height: 65px;
            background-color: #091a2b;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar img {
            width: 250px;
            transition: transform 0.3s ease;
            padding-top: 5px;
        }

        .navbar:hover img {
            transform: scale(1.02);
        }

        .navbar-links {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        .navbar-links form {
            display: inline-block;
            margin: 0 20px;
            font-weight: bold;
            transition: opacity 0.3s;
        }

        .navbar-links a,
        .navbar-links button {
            color: #fff;
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            font: inherit;
            text-decoration: none;
            display: inline-block;
            transition: opacity 0.3s;
        }

        .navbar-links a:hover,
        .navbar-links button:hover {
            opacity: 0.6;
        }

        .menu-icon {
            font-size: 24px;
            cursor: pointer;
            display: none;
            transition: transform 0.3s ease;
        }

        .menu-icon:hover {
            transform: scale(1.1);
        }

        .lock-icon {
            cursor: pointer;
            width: 40px;
            transition: transform 0.5s ease;
        }

        .lock-icon img {
            width: 100%;
        }

        @media screen and (max-width: 768px) {
            .menu-icon {
                display: block;
            }

            .navbar-links {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: #091a2b;
                flex-direction: column;
                align-items: center;
                display: none;
                padding: 20px 0;
                border-radius: 0 0 5px 5px;
            }

            .navbar-links.active {
                display: flex;
            }

            .navbar-links form {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .navbar-links a,
            .navbar-links button {
                display: block;
                width: 100%;
                text-align: center;
            }
        }

        @media screen and (min-width: 769px) {
            .lock-icon {
                margin-left: auto;
            }

            .menu-icon {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <a href="../src/index.php"><img src="../../shared/images/image.png" alt="Logo"></a>

        <!-- Iniciar formulario que incluye botones y enlaces -->
        <div class="navbar-links">
            <form action="../includes/procesar_busqueda.php" method="post">
                <!-- Botones para tipo de contrato -->
                <button type="submit" name="inmueble_tipo_contrato" value="Venta">Comprar</button>
                <button type="submit" name="inmueble_tipo_contrato" value="Alquiler">Alquilar</button>
                <button type="submit" name="inmueble_tipo_contrato" value="Compartir">Compartir</button>

                <!-- Enlaces a otras páginas que no necesitan formularios -->
                <a href="javascript:void(0);" onclick="redirectTo('../src/nosotros.php')">Nosotros</a>
                <a href="javascript:void(0);" onclick="redirectTo('../src/servicios.php')">Servicios</a>
                <a href="javascript:void(0);" onclick="redirectTo('../src/contacto.php')">Contacto</a>
            </form>
        </div>

        <a href="../../shared/login.php" class="lock-icon"><img src="../../shared/images/lock.webp" alt="Lock"></a>
    </div>

    <script>
        function toggleMenu() {
            const links = document.querySelector('.navbar-links');
            links.classList.toggle('active');
        }

        function redirectTo(page) {
            window.location.href = page;
        }
    </script>

</body>

</html>