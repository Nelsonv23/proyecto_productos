<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/database.php';
require_once '../models/ProductModel.php';

$codigo = $_POST['codigo'] ?? '';

if (!$codigo) {
    echo json_encode(['exists' => false]);
    exit;
}

$model = new ProductModel($conn);
$exists = $model->codigoExiste($codigo);

echo json_encode(['exists' => $exists]);
$conn->close();
?>