<?php include '../../includes/check_login.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            width: 100%;
            margin: 0;
            background-color: #f6f6f6;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #091a2b;
            color: #fff;
        }

        .contenedor {
            flex: 1;
            /*Ocupar ancho restante*/
            padding: 20px;
        }

        .sidebar-logo {
            border-bottom: 1px solid #282c34;
        }

        .sidebar-logo img {
            max-width: 85%;
            padding: 18px;
        }

        .menu-item h2 {
            padding: 10px 20px;
            font-size: 20px;
            cursor: pointer;
            margin: 0;
            background-color: #091a2b;
            border-bottom: 1px solid #282c34;
            white-space: nowrap;
        }

        .menu-item h2:hover {
            background-color: #3b4876;
        }

        .submenu {
            list-style: none;
            padding: 0;
            display: none;
        }

        .submenu li a {
            display: block;
            padding: 10px 20px;
            color: #cfd2d6;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .submenu li a:hover {
            background-color: #3b4876;
        }
    </style>
</head>

<body>

    <div id="sidebar" class="sidebar">

        <div class="sidebar-logo">
            <a href="../inicio/dashboard.php">
                <img src="../../../shared/images/image.png" alt="Logo de la barra lateral">
            </a>
        </div>

        <div class="sidebar-menu">
            <!-- Inicio -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('inicio')"><span class="icon"><i class="fas fa-home"></i></span> Inicio</h2>
                <ul class="submenu" id="inicio">
                    <li><a href="../inicio/dashboard.php">Dashboard</a></li>
                </ul>
            </div>

            <!-- Email -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('email')"><span class="icon"><i class="fas fa-envelope"></i></span> Email
                </h2>
                <ul class="submenu" id="email">
                    <li><a href="../email/email.php">Ver correo</a></li>
                    <li><a href="../email/enviar_correo.php">Enviar correo</a></li>
                </ul>
            </div>

            <!-- Inmuebles -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('inmuebles')"><span class="icon"><i class="fas fa-building"></i></span>
                    Inmuebles</h2>
                <ul class="submenu" id="inmuebles">
                    <li><a href="../inmuebles/insertar_inmueble.php">Insertar inmueble</a></li>
                    <li><a href="../inmuebles/mis_inmuebles.php">Mis inmuebles</a></li>
                    <li><a href="../src/inmuebles/inmuebles_disponibles.php">Inmuebles disponibles</a></li>
                    <li><a href="../src/inmuebles/inmuebles_vendidos.php">Inmuebles vendidos</a></li>
                </ul>
            </div>

            <!-- Clientes -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('clientes')"><span class="icon"><i class="fas fa-users"></i></span> Clientes
                </h2>
                <ul class="submenu" id="clientes">
                    <li><a href="../clientes/insertar_cliente.php">Insertar clientes</a></li>
                    <li><a href="../clientes/mis_clientes.php">Mis clientes</a></li>
                    <li><a href="../clientes/mis_contactos.php">Mis contactos</a></li>
                </ul>
            </div>

            <!-- Colaboradores -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('colaboradores')"><span class="icon"><i class="fas fa-users"></i></span> Colaboradores
                </h2>
                <ul class="submenu" id="colaboradores">
                    <li><a href="../colaboradores/insertar_colaborador.php">Insertar colaborador</a></li>
                    <li><a href="../colaboradores/mis_colaboradores.php">Mis colaboradores</a></li>
                </ul>
            </div>

            <!-- Contratos -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('contratos')"><span class="icon"><i class="fas fa-file-contract"></i></span>
                    Contratos</h2>
                <ul class="submenu" id="contratos">
                    <li><a href="../contratos/crear_contrato.php">Crear contrato</a></li>
                    <li><a href="../contratos/contratos_activos.php">Contratos activos</a></li>
                    <li><a href="../contratos/contratos_finalizados.php">Contratos finalizados</a></li>
                </ul>
            </div>

            <!-- Finanzas -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('finanzas')"><span class="icon"><i class="fas fa-coins"></i></span> Finanzas
                </h2>
                <ul class="submenu" id="finanzas">
                    <li><a href="../finanzas/facturacion.php">Facturación</a></li>
                    <li><a href="../finanzas/gastos.php">Gastos</a></li>
                    <li><a href="../finanzas/informes_financieros.php">Informes financieros</a></li>
                </ul>
            </div>

            <!-- Tareas -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('tareas')"><span class="icon"><i class="fas fa-tasks"></i></span> Tareas</h2>
                <ul class="submenu" id="tareas">
                    <li><a href="../tareas/tareas_pendientes.php">Tareas pendientes</a></li>
                    <li><a href="../tareas/tareas_asignadas.php">Tareas asignadas</a></li>
                    <li><a href="../tareas/crear_tarea.php">Crear tarea</a></li>
                </ul>
            </div>

            <!-- Reportes -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('reportes')"><span class="icon"><i class="fas fa-chart-bar"></i></span>
                    Reportes</h2>
                <ul class="submenu" id="reportes">
                    <li><a href="../reportes/reporte_ventas.php">Reporte de ventas</a></li>
                    <li><a href="../reportes/reporte_inmuebles.php">Reporte de inmuebles</a></li>
                    <li><a href="../reportes/reporte_financiero.php">Reporte financiero</a></li>
                </ul>
            </div>

            <!-- Agenda -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('agenda')"><span class="icon"><i class="fas fa-calendar-alt"></i></span>
                    Agenda</h2>
                <ul class="submenu" id="agenda">
                    <li><a href="../agenda/agenda.php">Ver agenda</a></li>
                    <li><a href="../agenda/agenda_configuracion.php">Configuración de agenda</a></li>
                </ul>
            </div>

            <!-- Copia de seguridad -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('copia')"><span class="icon"><i class="fas fa-database"></i></span> Copia de
                    seguridad</h2>
                <ul class="submenu" id="copia">
                    <li><a href="../copia/copia.php">Hacer copia de seguridad</a></li>
                    <li><a href="../copia/copia_historial.php">Historial de copias</a></li>
                </ul>
            </div>

            <!-- Configuración -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('configuracion')"><span class="icon"><i class="fas fa-cogs"></i></span>
                    Configuración</h2>
                <ul class="submenu" id="configuracion">
                    <li><a href="../configuracion/configuracion_general.php">Configuración general</a></li>
                    <li><a href="../configuracion/usuarios.php">Usuarios</a></li>
                    <li><a href="../configuracion/perfiles.php">Perfiles de usuario</a></li>
                </ul>
            </div>

            <!-- Mis datos -->
            <div class="menu-item">
                <h2 onclick="toggleSubMenu('misdatos')"><span class="icon"><i class="fas fa-user-circle"></i></span> Mis
                    datos</h2>
                <ul class="submenu" id="misdatos">
                    <li><a href="../mis_datos/perfil.php">Ver perfil</a></li>
                    <li><a href="../mis_datos/logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script>

        function toggleSubMenu(sectionId) {
            var submenu = document.getElementById(sectionId);
            if (submenu.style.display === 'none' || submenu.style.display === '') {
                submenu.style.display = 'block';
            } else {
                submenu.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Si se abre un menu se cierra otro
            var headers = document.querySelectorAll('.menu-item h2');
            headers.forEach(header => {
                header.onclick = function () {
                    var openMenus = document.querySelectorAll('.submenu');
                    openMenus.forEach(menu => {
                        if (menu.id !== this.nextElementSibling.id) {
                            menu.style.display = 'none';
                        }
                    });
                    toggleSubMenu(this.nextElementSibling.id);
                };
            });
        });

    </script>

</body>

</html>