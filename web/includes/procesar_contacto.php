<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si la cookie para el formulario enviado está establecida
    if (!isset($_COOKIE['ultimo_envio']) || (time() - $_COOKIE['ultimo_envio']) > 60) {
        // La cookie no está establecida o han pasado más de 60 segundos desde el último envío

        // Establece la cookie para el formulario enviado
        setcookie('ultimo_envio', time(), time() + 60); // Se establece la cookie para 1 minuto

        // Recoge los datos del formulario
        $nombre = $_POST["nombre"];
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        $telefono = $_POST["telefono"];
        $mensaje = isset($_POST["mensaje"]) ? $_POST["mensaje"] : null;
        $id_inmueble = isset($_POST["id_inmueble"]) ? $_POST["id_inmueble"] : null;

        // Establece la conexión con la base de datos
        include '../../shared/includes/obtener_conexion.php';

        // Prepara la consulta SQL para insertar los datos en la tabla "contactos"
        $sql = "INSERT INTO contactos (contacto_nombre, contacto_email, contacto_tlf, contacto_mensaje, contacto_inmueble_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        // Vincula los parámetros
        $stmt->bind_param("ssssi", $nombre, $email, $telefono, $mensaje, $id_inmueble);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Redirecciona con un mensaje de confirmación
            header("Location: ../src/contacto.php?mensaje=enviado");
            exit;
        } else {
            // En caso de fallo, redirecciona con un mensaje de error
            header("Location: ../src/contacto.php?mensaje=error");
            exit;
        }
    } else {
        // Se ha enviado un formulario dentro del último minuto
        header("Location: ../src/contacto.php?mensaje=Limite de envío alcanzado. Por favor, espere un momento antes de enviar otro formulario.");
        exit; // Termina la ejecución del script después de la redirección
    }
}