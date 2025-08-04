<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/database.php';
require_once '../models/ProductModel.php';

// Recibir datos
$codigo = trim($_POST['codigo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$bodega_id = $_POST['bodega'] ?? '';
$sucursal_id = $_POST['sucursal'] ?? '';
$moneda_id = $_POST['moneda'] ?? '';
$precio = trim($_POST['precio'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$materiales = $_POST['material'] ?? [];

// Validaciones (como en JS)
if (empty($codigo)) {
    echo json_encode(['success' => false, 'message' => 'El código del producto no puede estar en blanco.']);
    exit;
}
if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{5,15}$/', $codigo)) {
    if (!preg_match('/[a-zA-Z]/', $codigo)) {
        echo json_encode(['success' => false, 'message' => 'El código del producto debe contener letras y números']);
    } elseif (!preg_match('/\d/', $codigo)) {
        echo json_encode(['success' => false, 'message' => 'El código del producto debe contener letras y números']);
    } else {
        echo json_encode(['success' => false, 'message' => 'El código del producto debe tener entre 5 y 15 caracteres.']);
    }
    exit;
}

if (empty($nombre)) {
    echo json_encode(['success' => false, 'message' => 'El nombre del producto no puede estar en blanco.']);
    exit;
}
if (strlen($nombre) < 2 || strlen($nombre) > 50) {
    echo json_encode(['success' => false, 'message' => 'El nombre del producto debe tener entre 2 y 50 caracteres.']);
    exit;
}

if (empty($bodega_id)) {
    echo json_encode(['success' => false, 'message' => 'Debe seleccionar una bodega.']);
    exit;
}
if (empty($sucursal_id)) {
    echo json_encode(['success' => false, 'message' => 'Debe seleccionar una sucursal para la bodega seleccionada.']);
    exit;
}
if (empty($moneda_id)) {
    echo json_encode(['success' => false, 'message' => 'Debe seleccionar una moneda para el producto.']);
    exit;
}

if (empty($precio)) {
    echo json_encode(['success' => false, 'message' => 'El precio del producto no puede estar en blanco.']);
    exit;
}
if (!preg_match('/^\d+(\.\d{1,2})?$/', $precio)) {
    echo json_encode(['success' => false, 'message' => 'El precio del producto debe ser un número positivo con hasta dos decimales.']);
    exit;
}

if (count($materiales) < 2) {
    echo json_encode(['success' => false, 'message' => 'Debe seleccionar al menos dos materiales para el producto.']);
    exit;
}

if (empty($descripcion)) {
    echo json_encode(['success' => false, 'message' => 'La descripción del producto no puede estar en blanco.']);
    exit;
}
if (strlen($descripcion) < 10 || strlen($descripcion) > 1000) {
    echo json_encode(['success' => false, 'message' => 'La descripción del producto debe tener entre 10 y 1000 caracteres.']);
    exit;
}

// Valida si el producto existe
$model = new ProductModel($conn);

if ($model->codigoExiste($codigo)) {
    echo json_encode(['success' => false, 'message' => 'El código del producto ya está registrado.']);
    exit;
}

$result = $model->insertarProducto([
    'codigo' => $codigo,
    'nombre' => $nombre,
    'bodega_id' => $bodega_id,
    'sucursal_id' => $sucursal_id,
    'moneda_id' => $moneda_id,
    'precio' => $precio,
    'descripcion' => $descripcion,
    'materiales' => $materiales
]);

if ($result['success']) {
    echo json_encode(['success' => true, 'message' => 'Producto guardado exitosamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $result['error']]);
}

// cierra la conexión a la BD
$conn->close();
?>