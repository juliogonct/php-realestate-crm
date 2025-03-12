<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Subir Imágenes</title>
    <style>
        #preview-parent {
            display: flex;
            flex-wrap: wrap;
        }

        .preview {
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 5px;
            position: relative;
            width: 170px;
            height: 170px;
            overflow: hidden;
        }

        .preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview button {
            position: absolute;
            bottom: 10px;
            left: 10px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background: #2c1862;
            color: #fff;
            cursor: pointer;
        }

        button#selectImagesBtn {
            background-color: #091a2b;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <input type="file" id="fileInput" multiple style="display: none;">
    <button id="selectImagesBtn" onclick="document.getElementById('fileInput').click();">Seleccionar Imágenes</button>
    <div id="preview-parent"></div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    const fileInput = document.getElementById('fileInput');
    const previewParent = document.getElementById('preview-parent');
    let imagesData = [];

    fileInput.addEventListener('change', function () {
        const files = this.files;
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.createElement('div');
                preview.className = 'preview';
                preview.innerHTML = `<img src="${e.target.result}"><button onclick="removePreview(this)">Eliminar</button>`;
                previewParent.appendChild(preview);
                imagesData.push({
                    name: file.name,
                    data: e.target.result
                });
                sendUpdate();
            };
            reader.readAsDataURL(file);
        });
    });

    function removePreview(button) {
        const previewDiv = button.parentNode;
        previewDiv.remove(); // Elimina la vista previa del DOM
        sendUpdate(); // Actualiza el estado después de la eliminación
    }

    new Sortable(previewParent, {
        animation: 150,
        onEnd: () => {
            sendUpdate(); // Actualiza los datos tras reordenar
        }
    });

    function sendUpdate() {
        imagesData = [];
        document.querySelectorAll('#preview-parent .preview img').forEach((img, index) => {
            imagesData.push({
                name: index + 1,
                data: img.src
            });
        });
        parent.postMessage({ imagesData: imagesData }, '*');
    }
</script>


</html>