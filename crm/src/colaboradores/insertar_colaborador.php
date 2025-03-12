<?php
include '../../templates/sidebar.php';
include '../../includes/conexion.php';

// Inicializar un arreglo vacío para almacenar los datos del colaborador
$colaborador = array(
    'colab_tipo' => '',
    'colab_nombre' => '',
    'colab_dni' => '',
    'colab_tlf1' => '',
    'colab_tlf2' => '',
    'colab_email' => '',
    'colab_comentario' => ''
);

// Verificar si se proporciona un ID de colaborador
if (isset($_GET['colab_id'])) {
    // Obtener el ID del colaborador desde la URL
    $colab_id = $_GET['colab_id'];

    // Consultar los datos del colaborador desde la base de datos
    $query = "SELECT * FROM colaboradores WHERE colab_id = $colab_id";
    $result = mysqli_query($conexion, $query);

    // Verificar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Obtener los datos del colaborador y almacenarlos en el arreglo $colaborador
        $colaborador = mysqli_fetch_assoc($result);
    } else {
        // No se encontraron datos del colaborador, mostrar un mensaje de error o redirigir a una página de error
        echo "El colaborador con ID $colab_id no fue encontrado.";
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
    <title><?php echo isset($_GET['colab_id']) ? 'Actualizar Colaborador' : 'Insertar Colaborador'; ?></title>
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

            <form action="procesar_colaborador.php" method="POST" onsubmit="return validarFormulario();">
                <div class="form-container">

                    <!-- Campo oculto para almacenar el ID del colaborador -->
                    <input type="hidden" name="colab_id"
                        value="<?php echo isset($_GET['colab_id']) ? $_GET['colab_id'] : ''; ?>">

                    <label for="colab_tipo">Tipo de Colaborador:</label>
                    <select name="colab_tipo" id="colab_tipo">
                        <option value="" disabled> -- Escoja una opción -- </option>
                        <?php
                        $colab_tipos = array("Agente Inmobiliario", "Asesor Financiero", "Abogado", "Inspector", "Tasador", "Notario");
                        foreach ($colab_tipos as $tipo) {
                            echo '<option value="' . $tipo . '"';
                            echo $colaborador['colab_tipo'] == $tipo ? ' selected' : '';
                            echo '>' . $tipo . '</option>';
                        }
                        ?>
                    </select><br>

                    <label for="colab_nombre">Nombre:</label>
                    <input type="text" id="colab_nombre" name="colab_nombre"
                        value="<?php echo $colaborador['colab_nombre']; ?>" required><br>

                    <label for="colab_dni">DNI:</label>
                    <input type="text" id="colab_dni" name="colab_dni"
                        value="<?php echo $colaborador['colab_dni']; ?>"><br>

                    <label for="colab_tlf1">Teléfono 1:</label>
                    <input type="text" id="colab_tlf1" name="colab_tlf1"
                        value="<?php echo $colaborador['colab_tlf1']; ?>"><br>

                    <label for="colab_tlf2">Teléfono 2:</label>
                    <input type="text" id="colab_tlf2" name="colab_tlf2"
                        value="<?php echo $colaborador['colab_tlf2']; ?>"><br>

                    <label for="colab_email">Email:</label>
                    <input type="text" id="colab_email" name="colab_email"
                        value="<?php echo $colaborador['colab_email']; ?>"><br>

                    <label for="colab_comentario">Comentario:</label>
                    <input type="text" id="colab_comentario" name="colab_comentario"
                        value="<?php echo $colaborador['colab_comentario']; ?>"><br>

                </div>

                <button
                    type="submit"><?php echo isset($_GET['colab_id']) ? 'Actualizar Colaborador' : 'Insertar Colaborador'; ?></button>
            </form>

        </section>
    </div>
</body>


<script>
    function validarFormulario() {
        var colabTipo = document.getElementById("colab_tipo").value;
        var colabNombre = document.getElementById("colab_nombre").value;

        if (colabTipo === "") {
            alert("Por favor seleccione el tipo de colaborador.");
            return false;
        }

        if (colabNombre.trim() === "") {
            alert("Por favor ingrese el nombre del colaborador.");
            return false;
        }

        return true; // Retorna true si la validación pasa
    }
</script>

</html>