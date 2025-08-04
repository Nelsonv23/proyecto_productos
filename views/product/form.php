<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="/Desis/assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Formulario de Producto</h1>
        <form id="productForm">
            <!-- Código del Producto -->
            <div class="row">
                <div class="col">
                    <label for="codigo">Código del Producto:</label>
                    <input type="text" id="codigo" name="codigo" placeholder="PROD01K">
                </div>
                <div class="col">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Set Comedor">
                </div>
            </div>

            <!-- Bodega y Sucursal -->
            <div class="row">
                <div class="col">
                    <label for="bodega">Bodega:</label>
                    <select id="bodega" name="bodega">
                        <option value="">Seleccionar Bodega</option>
                    </select>
                </div>
                <div class="col">
                    <label for="sucursal">Sucursal:</label>
                    <select id="sucursal" name="sucursal">
                        <option value="">Seleccionar Sucursal</option>
                    </select>
                </div>
            </div>

            <!-- Moneda y Precio -->
            <div class="row">
                <div class="col">
                    <label for="moneda">Moneda:</label>
                    <select id="moneda" name="moneda">
                        <option value="">Seleccionar Moneda</option>
                    </select>
                </div>
                <div class="col">
                    <label for="precio">Precio:</label>
                    <input type="text" id="precio" name="precio" placeholder="1500">
                </div>
            </div>

            <!-- Material del Producto -->
            <div class="row">
                <div class="col">
                    <label for="material">Material del Producto:</label><br>
                    <div class="checkbox-group">
                        <input type="checkbox" id="plastico" name="material[]" value="Plástico">
                        <label for="plastico">Plástico</label>
                        <input type="checkbox" id="metal" name="material[]" value="Metal">
                        <label for="metal">Metal</label>
                        <input type="checkbox" id="madera" name="material[]" value="Madera">
                        <label for="madera">Madera</label>
                        <input type="checkbox" id="vidrio" name="material[]" value="Vidrio">
                        <label for="vidrio">Vidrio</label>
                        <input type="checkbox" id="textil" name="material[]" value="Textil">
                        <label for="textil">Textil</label>
                    </div>
                </div>
            </div>

            <!-- Descripción del Producto -->
            <div class="row">
                <div class="col">
                    <label for="descripcion">Descripción del Producto:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Escribe una descripción..."></textarea>
                </div>
            </div>

            <!-- Botón de Guardar -->
            <button type="submit" id="guardarProducto">Guardar Producto</button>
        </form>
    </div>

    <script src="/Desis/assets/js/script.js"></script>
</body>
</html>