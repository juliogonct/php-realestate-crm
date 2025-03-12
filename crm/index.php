<?php

session_start();

// Utilidad para cargar la whitelist de usuarios permitidos
function cargar_whitelist()
{
    return file('../data/whitelist.txt', FILE_IGNORE_NEW_LINES);
}

// Utilidad para generar contraseñas
function generar_contrasena()
{
    $chars = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
    $password = '';
    for ($i = 0; $i < 12; $i++) {
        $password .= $chars[array_rand($chars)];
    }
    return $password;
}

// Utilidad para cargar las contraseñas guardadas
function cargar_contrasenas()
{
    if (file_exists('../data/passwords.json')) {
        return json_decode(file_get_contents('../data/passwords.json'), true);
    } else {
        return [];
    }
}

// Utilidad para cargar las IPs asociadas a los usuarios
function cargar_ips()
{
    if (file_exists('../data/ips.json')) {
        return json_decode(file_get_contents('../data/ips.json'), true);
    } else {
        return [];
    }
}

// Guardar el estado de las contraseñas en un archivo JSON
function guardar_contrasenas($contrasenas)
{
    file_put_contents('../data/passwords.json', json_encode($contrasenas, JSON_PRETTY_PRINT));
}

// Guardar el estado de las IPs asociadas a los usuarios en un archivo JSON
function guardar_ips($ips)
{
    file_put_contents('../data/ips.json', json_encode($ips, JSON_PRETTY_PRINT));
}

// Ruta de procesamiento de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_STRING);
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $password_default = "admin"; // Contraseña por defecto

    // Cargar la lista de usuarios permitidos
    $whitelist = cargar_whitelist();

    // Si el usuario no está en la whitelist, redirigir a login.php
    if (!in_array($username, $whitelist)) {
        error_log("Intento de inicio de sesión fallido - IP: $user_ip - Usuario: $username (Usuario no permitido)");
        header("Location: ../shared/login.php");
        exit;
    }

    // Cargar las contraseñas guardadas
    $contrasenas = cargar_contrasenas();

    // Si se introduce la contraseña por defecto y el usuario está en la whitelist
    if ($password == $password_default && in_array($username, $whitelist)) {
        // Generar nueva contraseña para el usuario
        $new_password = generar_contrasena();
        $contrasenas[$username] = ['password' => $new_password];
        guardar_contrasenas($contrasenas);
        error_log("Contraseña generada para el usuario $username - IP: $user_ip");
        header("Location: ../shared/login.php");
        exit;
    }

    // Cargar las IPs asociadas a los usuarios
    $ips = cargar_ips();

    // Si se intenta acceder al dashboard sin IP asociada, redirigir al login y enviar correo al admin
    if (!isset($ips[$username]) || !in_array($user_ip, $ips[$username])) {
        error_log("Intento de inicio de sesión desde nueva IP - IP: $user_ip - Usuario: $username");
        enviar_correo_admin($username, $user_ip);
        header("Location: ../shared/login.php");
        exit;
    }

    // Si la contraseña introducida y la ip del equipo coinciden con el usuario, iniciar sesión y redirigir a dashboard.php
    if (
        isset($contrasenas[$username]) && isset($ips[$username]) &&
        $password == $contrasenas[$username]['password'] &&
        in_array($user_ip, $ips[$username])
    ) {
        $_SESSION['username'] = $username;
        $_SESSION['logged_in'] = true;
        error_log("Inicio de sesión exitoso - IP: $user_ip - Usuario: $username");
        header("Location: ../crm/src/inicio/dashboard.php");
        exit;
    }


    // Si la contraseña no coincide, registrar intento de inicio de sesión fallido y redirigir a login.php
    error_log("Intento de inicio de sesión fallido - IP: $user_ip - Usuario: $username (Contraseña incorrecta)");
    header("Location: ../shared/login.php");
    exit;
}

// Utilidad para enviar correo al administrador
function enviar_correo_admin($usuario, $ip)
{
    // Este codigo es utilizado momentaneamente hasta que pueda implementar un correo

    // Cargar las IPs asociadas a los usuarios
    $ips = cargar_ips();

    // Añadir la IP al usuario
    if (!isset($ips[$usuario])) {
        $ips[$usuario] = [];
    }
    $ips[$usuario][] = $ip;

    // Guardar las IPs actualizadas
    guardar_ips($ips);
}

