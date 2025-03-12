<?php
// Verificar si se recibieron los datos del formulario mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once '../../includes/conexion.php';

    // Recuperar el ID del cliente, si está presente
    $cliente_id = isset($_POST["cliente_id"]) ? $_POST["cliente_id"] : null;

    // Recuperar los datos del formulario y guardarlos en variables PHP
    $cliente_tipo = $_POST['cliente_tipo'];
    $cliente_nombre = $_POST['cliente_nombre'];
    $cliente_dni = $_POST['cliente_dni'];
    $cliente_tlf1 = $_POST['cliente_tlf1'];
    $cliente_tlf2 = $_POST['cliente_tlf2'];
    $cliente_email = $_POST['cliente_email'];
    $cliente_comentario = $_POST['cliente_comentario'];

    // Construir la consulta SQL para insertar o actualizar el cliente
    if (isset($_POST['cliente_id']) && !empty($_POST['cliente_id'])) {
        // Si hay un ID de cliente, realizamos una actualización
        $cliente_id = $_POST['cliente_id'];
        $sql = "UPDATE clientes SET 
            cliente_tipo = ?,
            cliente_nombre = ?,
            cliente_dni = ?,
            cliente_tlf1 = ?,
            cliente_tlf2 = ?,
            cliente_email = ?,
            cliente_comentario = ?
            WHERE cliente_id = ?";
    } else {
        // Si no hay un ID de cliente, realizamos una inserción
        $sql = "INSERT INTO clientes (cliente_tipo, cliente_nombre, cliente_dni, cliente_tlf1, cliente_tlf2, cliente_email, cliente_comentario)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    }

    // Preparar la consulta SQL
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        // Vincular parámetros
        if (isset($_POST['cliente_id']) && !empty($_POST['cliente_id'])) {
            $stmt->bind_param("sssssssi", $cliente_tipo, $cliente_nombre, $cliente_dni, $cliente_tlf1, $cliente_tlf2, $cliente_email, $cliente_comentario, $cliente_id);
        } else {
            $stmt->bind_param("sssssss", $cliente_tipo, $cliente_nombre, $cliente_dni, $cliente_tlf1, $cliente_tlf2, $cliente_email, $cliente_comentario);
        }

        // Ejecutar la consulta preparada
        if ($stmt->execute()) {
            // Redirigir con un mensaje de éxito
            header("Location: mis_clientes.php?mensaje=" . ($cliente_id ? "Cliente actualizado correctamente" : "Cliente insertado correctamente"));
            exit();
        } else {
            // Redirigir con un mensaje de error si falla la consulta
            header("Location: insertar_cliente.php?mensaje=Error al ejecutar la consulta");
            exit();
        }
    } else {
        // Redirigir con un mensaje de error si falla la preparación de la consulta
        header("Location: insertar_cliente.php?mensaje=Error al preparar la consulta");
        exit();
    }
}