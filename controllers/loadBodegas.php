<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/database.php';
require_once '../models/ProductModel.php';

// Carga las bodegas en le select
$model = new ProductModel($conn);
$bodegas = $model->getBodegas();

echo json_encode(['success' => true, 'bodegas' => $bodegas]);
$conn->close();
?>