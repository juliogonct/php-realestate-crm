<?php
// Verificar si se recibieron los datos del formulario mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include_once '../../includes/conexion.php';

    // Función para limpiar y validar datos
    function validarDatos($dato)
    {
        // Reglas de validación
        return $dato;
    }

    // Recuperar el ID del inmueble, si está presente
    $inmueble_id = isset($_POST["inmueble_id"]) ? $_POST["inmueble_id"] : null;

    // Recuperar los datos del formulario y validarlos
    $tipo_inmueble = validarDatos($_POST["tipo_inmueble"]);
    $tipo_vivienda = isset($_POST["tipo_vivienda"]) ? validarDatos($_POST["tipo_vivienda"]) : null;
    $tipo_contrato = validarDatos($_POST["tipo_contrato"]);
    $direccion = validarDatos($_POST["direccion"]);
    $ccaa_id = validarDatos($_POST["ccaa"]);
    $provincia_id = validarDatos($_POST["provincia"]);
    $municipio_id = validarDatos($_POST["municipio"]);
    $precio = validarDatos($_POST["precio"]);
    $superficie = validarDatos($_POST["superficie"]);
    $habitaciones = validarDatos($_POST["habitaciones"]);
    $banos = validarDatos($_POST["banos"]);
    $orientacion = validarDatos($_POST["orientacion"]);
    $estado = validarDatos($_POST["estado"]);
    $antiguedad = validarDatos($_POST["antiguedad"]);
    $descripcion = validarDatos($_POST["descripcion"]);
    $certificado = validarDatos($_POST["certificado"]);
    $propietario = isset($_POST["propietario"]) ? validarDatos($_POST["propietario"]) : null;
    $colaborador = isset($_POST["colab"]) ? validarDatos($_POST["colab"]) : null;

    // ========================================================================================================================

    // Obtener el nombre de la ccaa, provincia y municipio a partir de su ID
    $query_ccaa = "SELECT ccaa_nombre FROM ccaa WHERE ccaa_id = '$ccaa_id'";
    $query_provincia = "SELECT provincia_nombre FROM provincias WHERE provincia_id = '$provincia_id'";
    $query_municipio = "SELECT municipio_nombre FROM municipios WHERE municipio_id = '$municipio_id'";

    $result_ccaa = mysqli_query($conexion, $query_ccaa);
    $result_provincia = mysqli_query($conexion, $query_provincia);
    $result_municipio = mysqli_query($conexion, $query_municipio);

    $row_ccaa = mysqli_fetch_assoc($result_ccaa);
    $row_provincia = mysqli_fetch_assoc($result_provincia);
    $row_municipio = mysqli_fetch_assoc($result_municipio);

    $ccaa_nombre = $row_ccaa['ccaa_nombre'];
    $provincia_nombre = $row_provincia['provincia_nombre'];
    $municipio_nombre = $row_municipio['municipio_nombre'];

    // ========================================================================================================================

    // Recuperar los valores de los extras del formulario
    $extras = array(
        'extra_aire_acondicionado' => isset($_POST['extra_aire_acondicionado']) ? 1 : 0,
        'extra_amueblado' => isset($_POST['extra_amueblado']) ? 1 : 0,
        'extra_armarios' => isset($_POST['extra_armarios']) ? 1 : 0,
        'extra_ascensor' => isset($_POST['extra_ascensor']) ? 1 : 0,
        'extra_balcon' => isset($_POST['extra_balcon']) ? 1 : 0,
        'extra_calefaccion' => isset($_POST['extra_calefaccion']) ? 1 : 0,
        'extra_electrodomesticos' => isset($_POST['extra_electrodomesticos']) ? 1 : 0,
        'extra_garaje_privado' => isset($_POST['extra_garaje_privado']) ? 1 : 0,
        'extra_jardin' => isset($_POST['extra_jardin']) ? 1 : 0,
        'extra_lavadero' => isset($_POST['extra_lavadero']) ? 1 : 0,
        'extra_parquet' => isset($_POST['extra_parquet']) ? 1 : 0,
        'extra_parking_comunitario' => isset($_POST['extra_parking_comunitario']) ? 1 : 0,
        'extra_patio' => isset($_POST['extra_patio']) ? 1 : 0,
        'extra_piscina' => isset($_POST['extra_piscina']) ? 1 : 0,
        'extra_suite_con_bano' => isset($_POST['extra_suite_con_bano']) ? 1 : 0,
        'extra_terrazo' => isset($_POST['extra_terrazo']) ? 1 : 0,
        'extra_trastero' => isset($_POST['extra_trastero']) ? 1 : 0,
        'extra_videoportero' => isset($_POST['extra_videoportero']) ? 1 : 0,
        'extra_zona_comunitaria' => isset($_POST['extra_zona_comunitaria']) ? 1 : 0,
        'extra_zona_deportiva' => isset($_POST['extra_zona_deportiva']) ? 1 : 0,
        'extra_zona_infantil' => isset($_POST['extra_zona_infantil']) ? 1 : 0
    );

    // ========================================================================================================================

    // Construir la consulta SQL
    if ($inmueble_id) {
        // Si hay un ID de inmueble, realizamos una actualización
        $sql = "UPDATE inmuebles SET 
        inmueble_tipo_inmueble = '$tipo_inmueble',
        inmueble_tipo_vivienda = '$tipo_vivienda',
        inmueble_tipo_contrato = '$tipo_contrato',
        inmueble_dir = '$direccion',
        inmueble_ccaa = '$ccaa_nombre',
        inmueble_provincia = '$provincia_nombre',
        inmueble_municipio = '$municipio_nombre',
        inmueble_precio = '$precio',
        inmueble_superficie = '$superficie',
        inmueble_habitaciones = '$habitaciones',
        inmueble_banos = '$banos',
        inmueble_orientacion = '$orientacion',
        inmueble_estado = '$estado',
        inmueble_antiguedad = '$antiguedad',
        inmueble_descripcion = '$descripcion',
        inmueble_certificado = '$certificado',
        inmueble_propietario = '$propietario',
        inmueble_colab = '$colaborador',
        inmueble_fecha = NOW()
        WHERE inmueble_id = '$inmueble_id'";

        // También actualizamos los extras
        $sql_extras = "UPDATE extras SET 
        extra_aire_acondicionado = {$extras['extra_aire_acondicionado']},
        extra_amueblado = {$extras['extra_amueblado']},
        extra_armarios = {$extras['extra_armarios']},
        extra_ascensor = {$extras['extra_ascensor']},
        extra_balcon = {$extras['extra_balcon']},
        extra_calefaccion = {$extras['extra_calefaccion']},
        extra_electrodomesticos = {$extras['extra_electrodomesticos']},
        extra_garaje_privado = {$extras['extra_garaje_privado']},
        extra_jardin = {$extras['extra_jardin']},
        extra_lavadero = {$extras['extra_lavadero']},
        extra_parquet = {$extras['extra_parquet']},
        extra_parking_comunitario = {$extras['extra_parking_comunitario']},
        extra_patio = {$extras['extra_patio']},
        extra_piscina = {$extras['extra_piscina']},
        extra_suite_con_bano = {$extras['extra_suite_con_bano']},
        extra_terrazo = {$extras['extra_terrazo']},
        extra_trastero = {$extras['extra_trastero']},
        extra_videoportero = {$extras['extra_videoportero']},
        extra_zona_comunitaria = {$extras['extra_zona_comunitaria']},
        extra_zona_deportiva = {$extras['extra_zona_deportiva']},
        extra_zona_infantil = {$extras['extra_zona_infantil']}
        WHERE inmueble_id = $inmueble_id";

        // Ejecutar las consultas SQL para actualizar el inmueble y sus extras
        if ($conexion->query($sql) === TRUE && $conexion->query($sql_extras) === TRUE) {
            // Redirigir con un mensaje de éxito
            header("Location: mis_inmuebles.php?mensaje=Inmueble actualizado correctamente");
            exit();
        } else {
            // Redirigir con un mensaje de error si falla la actualización
            header("Location: insertar_inmueble.php?mensaje=Error al actualizar el inmueble: " . $conexion->error);
            exit();
        }

        // ========================================================================================================================

    } else {
        
        // Si no hay un ID de inmueble, realizamos una inserción
        $sql = "INSERT INTO inmuebles (
        inmueble_tipo_inmueble, 
        inmueble_tipo_vivienda, 
        inmueble_tipo_contrato, 
        inmueble_dir,
        inmueble_ccaa,
        inmueble_provincia, 
        inmueble_municipio, 
        inmueble_precio, 
        inmueble_superficie, 
        inmueble_habitaciones, 
        inmueble_banos, 
        inmueble_orientacion, 
        inmueble_estado, 
        inmueble_antiguedad, 
        inmueble_descripcion, 
        inmueble_certificado, 
        inmueble_propietario, 
        inmueble_colab,
        inmueble_fecha
        ) 
        VALUES (
            '$tipo_inmueble', 
            '$tipo_vivienda', 
            '$tipo_contrato', 
            '$direccion',
            '$ccaa_nombre',
            '$provincia_nombre', 
            '$municipio_nombre', 
            '$precio', 
            '$superficie', 
            '$habitaciones', 
            '$banos', 
            '$orientacion', 
            '$estado', 
            '$antiguedad', 
            '$descripcion', 
            '$certificado', 
            '$propietario', 
            '$colaborador',
            NOW()
        )";

        // Ejecutar la consulta para insertar el inmueble
        if ($conexion->query($sql) === TRUE) {
            // Obtener el ID del último inmueble insertado
            $inmueble_id = $conexion->insert_id;

            // Construir la consulta SQL para insertar los extras asociados al inmueble
            $sql_extras = "INSERT INTO extras (
            extra_aire_acondicionado,
            extra_amueblado,
            extra_armarios,
            extra_ascensor,
            extra_balcon,
            extra_calefaccion,
            extra_electrodomesticos,
            extra_garaje_privado,
            extra_jardin,
            extra_lavadero,
            extra_parquet,
            extra_parking_comunitario,
            extra_patio,
            extra_piscina,
            extra_suite_con_bano,
            extra_terrazo,
            extra_trastero,
            extra_videoportero,
            extra_zona_comunitaria,
            extra_zona_deportiva,
            extra_zona_infantil,
            inmueble_id
        )
        VALUES (
            {$extras['extra_aire_acondicionado']},
            {$extras['extra_amueblado']},
            {$extras['extra_armarios']},
            {$extras['extra_ascensor']},
            {$extras['extra_balcon']},
            {$extras['extra_calefaccion']},
            {$extras['extra_electrodomesticos']},
            {$extras['extra_garaje_privado']},
            {$extras['extra_jardin']},
            {$extras['extra_lavadero']},
            {$extras['extra_parquet']},
            {$extras['extra_parking_comunitario']},
            {$extras['extra_patio']},
            {$extras['extra_piscina']},
            {$extras['extra_suite_con_bano']},
            {$extras['extra_terrazo']},
            {$extras['extra_trastero']},
            {$extras['extra_videoportero']},
            {$extras['extra_zona_comunitaria']},
            {$extras['extra_zona_deportiva']},
            {$extras['extra_zona_infantil']},
            $inmueble_id
        )";

            // Ejecutar la consulta para insertar los extras
            $conexion->query($sql_extras);

            // ========================================================================================================================

            // Directorio de destino para las imágenes del inmueble
            $target_dir = "../../../shared/images/inmuebles/" . $inmueble_id . "/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true); // Crea el directorio si no existe con permisos de lectura y escritura
            }

            $imagesData = json_decode($_POST['hiddenInput']);
            foreach ($imagesData as $index => $imageData) {
                $image_parts = explode(";base64,", $imageData->data);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = $target_dir . $imageData->name . '.' . $image_type;

                file_put_contents($fileName, $image_base64);
                echo "El archivo " . htmlspecialchars($imageData->name) . " ha sido subido exitosamente.<br>";
            }

            // ========================================================================================================================

            // Redirigir con un mensaje de éxito
            header("Location: mis_inmuebles.php?mensaje=Inmueble insertado correctamente: ");
            exit();

        } else {
            // Redirigir con un mensaje de error
            header("Location: insertar_inmueble.php?mensaje=Error al insertar el inmueble: " . $conexion->error);
            exit();
        }
    }
    // Cerrar la conexión a la base de datos
    // $conexion->close();

    // Redirigir con un mensaje de error si se accede de forma incorrecta
    // header("Location: insertar_inmueble.php?mensaje=Error: Acceso denegado.");
    // exit();
}
