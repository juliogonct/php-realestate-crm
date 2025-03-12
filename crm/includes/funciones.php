<?php include '../../includes/check_login.php'; ?> 

<?php
function check_sesion()
{
    session_start();
    $pagina_excluida = array('login.php', 'logout.php', 'login');  // Páginas que no requieren verificación de sesión
    $script_name = basename($_SERVER['SCRIPT_NAME']);

    if (!in_array($script_name, $pagina_excluida)) {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: login.php");
            exit;
        }
    }
}

function validar_entrada($texto)
{
    return preg_match('/^[\w\sáéíóúÁÉÍÓÚñÑ]+$/', $texto);
}

function flash_message()
{
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);  // Elimina el mensaje después de mostrarlo para que no se repita
        return $message;
    }
    return '';
}
