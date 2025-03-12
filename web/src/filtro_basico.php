<style>
    .buscador {
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding-top: 15px;
        padding-bottom: 15px;
        position: absolute;
        min-width: 40%;
        top: 50%;
        /* Centrado vertical */
        left: 50%;
        /* Centrado horizontal */
        transform: translate(-50%, -40%);
        /* Centrado absoluto */
        text-align: center;
    }

    /* ======================================================================================================================== */

    /* Estilo base */
    .buscador label {
        width: 100px;
        cursor: pointer;
        display: inline-block;
        padding: 8px 16px;
        background-color: #091a2b;
        color: #fff;
        border: 1px solid #ccc;
        text-decoration: none;
        /* Asegura que no haya subrayado */
        transition: background-color 0.3s, color 0.3s;
        margin-bottom: 15px;
    }

    /* Ocultar el input checkbox real */
    .buscador input[type="checkbox"] {
        display: none;
    }

    /* Estilo cuando el checkbox está marcado */
    .buscador input[type="checkbox"]:checked+label {
        background-color: #3b4876;
        color: white;
    }

    /* Estilo para hover sobre cualquier etiqueta */
    .buscador label:hover {
        background-color: #005163;
        color: #fff;
    }

    /* Estilo para hover específicamente en etiquetas marcadas */
    .buscador input[type="checkbox"]:checked+label:hover {
        background-color: #005163;
    }

    /* Estilo para todos los checkboxes */
    .buscador input[type="checkbox"]+label {
        border-radius: 8px;
        margin-left: 5px;
        /* Eliminar espacio entre checkboxes */
    }

    /* ======================================================================================================================== */

    /* Estilo para select */
    .buscador select {
        width: 160px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right: 5px;
        padding: 9px;
    }

    /* ======================================================================================================================== */

    .buscador input[type="text"] {
        width: calc(100% - 360px);
        /* 100% del ancho menos el ancho del botón */
        min-width: 160px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 5px;
        margin-right: 10px;
        margin-bottom: 5px;
        padding: 9px;
    }

    /* ======================================================================================================================== */

    .buscador button {
        width: 120px;
        padding: 10px 30px;
        background-color: #091a2b;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .buscador button:hover {
        background-color: #005163;
    }
</style>

<div class="buscador">
    <form action="../includes/procesar_busqueda.php" method="POST" id="formBusqueda">

        <!-- ======================================================================================================================== -->

        <input type="checkbox" name="inmueble_tipo_contrato" id="venta" value="Venta" onchange="uncheckOthers(this)">
        <label for="venta">Venta</label>

        <input type="checkbox" name="inmueble_tipo_contrato" id="alquiler" value="Alquiler" onchange="uncheckOthers(this)">
        <label for="alquiler">Alquiler</label>

        <input type="checkbox" name="inmueble_tipo_contrato" id="Compartir" value="Compartir" onchange="uncheckOthers(this)">
        <label for="Compartir">Compartir</label>
        <br>

        <!-- ======================================================================================================================== -->

        <select name="inmueble_tipo_inmueble" id="tipo_inmueble" placeholder="Tipo de Inmueble">
            <option value="" disabled selected> Tipo de Inmueble </option>
            <option value="Vivienda">Vivienda</option>
            <option value="Garaje">Garaje</option>
            <option value="Terreno">Terreno</option>
            <option value="Local">Local</option>
            <option value="Oficina">Oficina</option>
            <option value="Trastero">Trastero</option>
        </select>

        <!-- ======================================================================================================================== -->

        <input type="text" name="inmueble_dir" id="inmueble_dir" placeholder="Dirección o municipio (En Construcción)">

        <button type="submit">Buscar</button>
    </form>
</div>

<script>
    function uncheckOthers(checkbox) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"][name="inmueble_tipo_contrato"]');
        checkboxes.forEach(function (cb) {
            if (cb !== checkbox) {
                cb.checked = false;
            }
        });
    }
</script>