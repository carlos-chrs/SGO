<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Archivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        .content-wrapper {
            width: 100%;
            max-width: 800px;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .thumbnail {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <h1 class="text-center mb-4">Gestión de Archivos</h1>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="header-tab" data-bs-toggle="tab" data-bs-target="#header" type="button" role="tab">Header</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="footer-tab" data-bs-toggle="tab" data-bs-target="#footer" type="button" role="tab">Footer</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="fonts-tab" data-bs-toggle="tab" data-bs-target="#fonts" type="button" role="tab">Fuentes</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="header" role="tabpanel" aria-labelledby="header-tab">
                <h3 class="mt-3">Header</h3>
                <form id="headerForm" class="mb-3">
                    <input type="hidden" name="type" value="header">
                    <div class="mb-3">
                        <label for="headerName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="headerName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="headerImage" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="headerImage" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir Header</button>
                </form>
                <div id="headerList"></div>
            </div>
            <div class="tab-pane fade" id="footer" role="tabpanel" aria-labelledby="footer-tab">
                <h3 class="mt-3">Footer</h3>
                <form id="footerForm" class="mb-3">
                    <input type="hidden" name="type" value="footer">
                    <div class="mb-3">
                        <label for="footerName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="footerName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="footerImage" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="footerImage" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir Footer</button>
                </form>
                <div id="footerList"></div>
            </div>
            <div class="tab-pane fade" id="fonts" role="tabpanel" aria-labelledby="fonts-tab">
                <h3 class="mt-3">Fuentes</h3>
                <form id="fontForm" class="mb-3">
                    <div class="mb-3">
                        <label for="fontFile" class="form-label">Archivo de Fuente</label>
                        <input type="file" class="form-control" id="fontFile" name="font" accept=".ttf,.otf,.woff,.woff2" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir Fuente</button>
                </form>
                <div id="fontList"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headerForm = document.getElementById('headerForm');
            const footerForm = document.getElementById('footerForm');
            const fontForm = document.getElementById('fontForm');

            headerForm.addEventListener('submit', handleImageSubmit);
            footerForm.addEventListener('submit', handleImageSubmit);
            fontForm.addEventListener('submit', handleFontSubmit);

            loadFiles('header');
            loadFiles('footer');
            loadFonts();

            function handleImageSubmit(event) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);

                fetch('/api/images', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    form.reset();
                    loadFiles(formData.get('type'));
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }

            function handleFontSubmit(event) {
                event.preventDefault();
                const formData = new FormData(fontForm);

                fetch('/api/fuentes', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    fontForm.reset();
                    loadFonts();
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }

            function loadFiles(type) {
                fetch(`/api/images?type=${type}`)
                .then(response => response.json())
                .then(data => {
                    const listElement = document.getElementById(`${type}List`);
                    listElement.innerHTML = '';
                    data.forEach(file => {
                        const fileName = file.split('/').pop();
                        const listItem = document.createElement('div');
                        listItem.className = 'mb-2 d-flex align-items-center';
                        listItem.innerHTML = `
                            <img src="/storage/images/${type}/${fileName}" class="thumbnail me-2" alt="${fileName}">
                            <span>${fileName}</span>
                            <button class="btn btn-sm btn-danger ms-2" onclick="deleteFile('${type}', '${fileName}')">Eliminar</button>
                        `;
                        listElement.appendChild(listItem);
                    });
                });
            }

            function loadFonts() {
                fetch('/api/fuentes')
                .then(response => response.json())
                .then(data => {
                    const listElement = document.getElementById('fontList');
                    listElement.innerHTML = '';
                    data.forEach(font => {
                        const fileName = font.split('/').pop();
                        const listItem = document.createElement('div');
                        listItem.className = 'mb-2';
                        listItem.innerHTML = `
                            <span>${fileName}</span>
                            <button class="btn btn-sm btn-danger ms-2" onclick="deleteFont('${fileName}')">Eliminar</button>
                        `;
                        listElement.appendChild(listItem);
                    });
                });
            }

            window.deleteFile = function(type, fileName) {
                if (confirm(`¿Estás seguro de que quieres eliminar ${fileName}?`)) {
                    fetch(`/api/images/${type}/${fileName}`, { method: 'DELETE' })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        loadFiles(type);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                }
            }

            window.deleteFont = function(fileName) {
                if (confirm(`¿Estás seguro de que quieres eliminar ${fileName}?`)) {
                    fetch(`/api/fuentes/${fileName}`, { method: 'DELETE' })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        loadFonts();
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                }
            }
        });
    </script>
</body>
</html>