<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Gestión Inmobiliaria</title>
    <!-- Estilos CSS -->
    <style>
        #contenido {
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            color: #333;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #000;
        }
    </style>
</head>

<body>

    <?php include '../../templates/sidebar.php'; ?>

    <div class="contenedor">
        <div id="contenido">
            <h1>Bienvenido al sistema de gestión de la inmobiliaria</h1>
            <p>¡Hola, usuario! En esta plataforma podrás gestionar todos los aspectos relacionados con la inmobiliaria
                de manera eficiente.</p>
            <p>Aquí podrás encontrar información sobre propiedades, clientes, contratos, finanzas, tareas y más.</p>
            <p>¡Explora las diferentes secciones del menú para comenzar a trabajar!</p>
            <a href="#" class="btn">Empezar</a>
        </div>
    </div>

</body>

</html>