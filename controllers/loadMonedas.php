<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/database.php';
require_once '../models/ProductModel.php';

// Carga los tipos de monedas en le select del formulario
$model = new ProductModel($conn);
$monedas = $model->getMonedas();

echo json_encode(['success' => true, 'monedas' => $monedas]);
$conn->close();
?>