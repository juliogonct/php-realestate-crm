<?php
// Verificar si se recibieron los datos del formulario mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once '../../includes/conexion.php';

    // Recuperar el ID del colaborador, si está presente
    $colab_id = isset($_POST["colab_id"]) ? $_POST["colab_id"] : null;

    // Recuperar los datos del formulario y guardarlos en variables PHP
    $colab_tipo = $_POST['colab_tipo'];
    $colab_nombre = $_POST['colab_nombre'];
    $colab_dni = $_POST['colab_dni'];
    $colab_tlf1 = $_POST['colab_tlf1'];
    $colab_tlf2 = $_POST['colab_tlf2'];
    $colab_email = $_POST['colab_email'];
    $colab_comentario = $_POST['colab_comentario'];

    // Construir la consulta SQL para insertar o actualizar el colaborador
    if (isset($_POST['colab_id']) && !empty($_POST['colab_id'])) {
        // Si hay un ID de colaborador, realizamos una actualización
        $colab_id = $_POST['colab_id'];
        $sql = "UPDATE colaboradores SET 
            colab_tipo = ?,
            colab_nombre = ?,
            colab_dni = ?,
            colab_tlf1 = ?,
            colab_tlf2 = ?,
            colab_email = ?,
            colab_comentario = ?
            WHERE colab_id = ?";
    } else {
        // Si no hay un ID de colaborador, realizamos una inserción
        $sql = "INSERT INTO colaboradores (colab_tipo, colab_nombre, colab_dni, colab_tlf1, colab_tlf2, colab_email, colab_comentario)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    }

    // Preparar la consulta SQL
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        // Vincular parámetros
        if (isset($_POST['colab_id']) && !empty($_POST['colab_id'])) {
            $stmt->bind_param("sssssssi", $colab_tipo, $colab_nombre, $colab_dni, $colab_tlf1, $colab_tlf2, $colab_email, $colab_comentario, $colab_id);
        } else {
            $stmt->bind_param("sssssss", $colab_tipo, $colab_nombre, $colab_dni, $colab_tlf1, $colab_tlf2, $colab_email, $colab_comentario);
        }

        // Ejecutar la consulta preparada
        if ($stmt->execute()) {
            // Redirigir con un mensaje de éxito
            header("Location: mis_colaboradores.php?mensaje=" . ($colab_id ? "Colaborador actualizado correctamente" : "Colaborador insertado correctamente"));
            exit();
        } else {
            // Redirigir con un mensaje de error si falla la consulta
            header("Location: insertar_colaborador.php?mensaje=Error al ejecutar la consulta");
            exit();
        }
    } else {
        // Redirigir con un mensaje de error si falla la preparación de la consulta
        header("Location: insertar_colaborador.php?mensaje=Error al preparar la consulta");
        exit();
    }
}