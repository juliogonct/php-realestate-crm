<?php
include '../../templates/sidebar.php';
include '../../includes/conexion.php';

// Inicializar un arreglo vacío para almacenar los datos del cliente
$cliente = array(
    'cliente_tipo' => '',
    'cliente_nombre' => '',
    'cliente_dni' => '',
    'cliente_tlf1' => '',
    'cliente_tlf2' => '',
    'cliente_email' => '',
    'cliente_comentario' => ''
);

// Verificar si se proporciona un ID de cliente
if (isset($_GET['cliente_id'])) {
    // Obtener el ID del cliente desde la URL
    $cliente_id = $_GET['cliente_id'];

    // Consultar los datos del cliente desde la base de datos
    $query = "SELECT * FROM clientes WHERE cliente_id = $cliente_id";
    $result = mysqli_query($conexion, $query);

    // Verificar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Obtener los datos del cliente y almacenarlos en el arreglo $cliente
        $cliente = mysqli_fetch_assoc($result);
    } else {
        // No se encontraron datos del cliente, mostrar un mensaje de error o redirigir a una página de error
        echo "El cliente con ID $cliente_id no fue encontrado.";
        exit(); // O redirigir a una página de error
    }

    // Liberar el resultado de la consulta
    mysqli_free_result($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_GET['cliente_id']) ? 'Actualizar Cliente' : 'Insertar Cliente'; ?></title>
    <style>
        /* Estilos específicos para la página */
        #contenido {
            padding: 20px;
            width: 100%;
        }

        /********************************************************************************************************************************/

        body {
            font-family: Arial, sans-serif;
        }

        .contenedor {
            background: white;
            border: 1px solid #ccc;
            /* Borde gris */
            border-radius: 10px;
            /* Bordes redondeados */
            padding: 20px;

        }

        /********************************************************************************************************************************/

        form {
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        /********************************************************************************************************************************/

        .form-container {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            width: calc(100% - 30px);
            /* Ancho del contenedor, 50% del ancho de la página menos márgenes */
            box-sizing: border-box;
            display: inline-block;
            /* Mostrar en línea para organizar en dos columnas */
            vertical-align: top;
            /* Alinear en la parte superior */
        }

        .form-container {
            margin-left: 15px;
            margin-right: 10px;
            margin-top: 10px;
            min-height: 400px;
            /* Espacio entre las columnas */
        }

        .form-container h3 {
            margin-top: 0;
        }

        /********************************************************************************************************************************/

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            width: 100%;
            min-height: 600px;
            border: #ccc;
            outline: none;
            resize: none;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #4a4a4a;
            width: 100%;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <div id="contenido">
        <section class="contenedor">

            <form action="procesar_cliente.php" method="POST" onsubmit="return validarFormulario();">
                <div class="form-container">

                    <!-- Campo oculto para almacenar el ID del cliente -->
                    <input type="hidden" name="cliente_id" value="<?php echo isset($_GET['cliente_id']) ? $_GET['cliente_id'] : ''; ?>">

                    <label for="cliente_tipo">Tipo de Cliente:</label>
                    <select name="cliente_tipo" id="cliente_tipo">
                        <option value="" disabled> -- Escoja una opción -- </option>
                        <?php
                        $cliente_tipos = array("Demandante", "Propietario", "Inversionista", "Arrendatario", "Promotor inmobiliario");
                        foreach ($cliente_tipos as $tipo) {
                            echo '<option value="' . $tipo . '"';
                            echo $cliente['cliente_tipo'] == $tipo ? ' selected' : '';
                            echo '>' . $tipo . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="cliente_nombre">Nombre:</label>
                    <input type="text" id="cliente_nombre" name="cliente_nombre"
                        value="<?php echo $cliente['cliente_nombre']; ?>" required><br>

                    <label for="cliente_dni">DNI:</label>
                    <input type="text" id="cliente_dni" name="cliente_dni"
                        value="<?php echo $cliente['cliente_dni']; ?>"><br>

                    <label for="cliente_tlf1">Teléfono 1:</label>
                    <input type="text" id="cliente_tlf1" name="cliente_tlf1"
                        value="<?php echo $cliente['cliente_tlf1']; ?>"><br>

                    <label for="cliente_tlf2">Teléfono 2:</label>
                    <input type="text" id="cliente_tlf2" name="cliente_tlf2"
                        value="<?php echo $cliente['cliente_tlf2']; ?>"><br>

                    <label for="cliente_email">Email:</label>
                    <input type="text" id="cliente_email" name="cliente_email"
                        value="<?php echo $cliente['cliente_email']; ?>"><br>

                    <label for="cliente_comentario">Comentario:</label>
                    <input type="text" id="cliente_comentario" name="cliente_comentario"
                        value="<?php echo $cliente['cliente_comentario']; ?>"><br>

                </div>
                
                <button type="submit"><?php echo isset($_GET['cliente_id']) ? 'Actualizar Cliente' : 'Insertar Cliente'; ?></button>
            </form>

        </section>
    </div>
</body>


<script>
    function validarFormulario() {
        var clienteTipo = document.getElementById("cliente_tipo").value;
        var clienteNombre = document.getElementById("cliente_nombre").value;

        if (clienteTipo === "") {
            alert("Por favor seleccione el tipo de cliente.");
            return false;
        }

        if (clienteNombre.trim() === "") {
            alert("Por favor ingrese el nombre del cliente.");
            return false;
        }

        return true; // Retorna true si la validación pasa
    }
</script>

</html>