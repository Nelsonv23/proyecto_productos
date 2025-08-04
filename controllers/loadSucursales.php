<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/database.php';
require_once '../models/ProductModel.php';

$bodega_id = $_POST['bodega_id'] ?? null;

if (!$bodega_id || !is_numeric($bodega_id)) {
    echo json_encode(['success' => false, 'sucursales' => []]);
    exit;
}

$model = new ProductModel($conn);
$sucursales = $model->getSucursalesByBodega($bodega_id);

echo json_encode(['success' => true, 'sucursales' => $sucursales]);
$conn->close();
?>