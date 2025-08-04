<?php
// Parametros de la BD
$host = "localhost";
$username = "root";
$password = "";
$dbname = "productos";

// Se crea conexión a la BD
$conn = new mysqli($host, $username, $password, $dbname);

// Se valida si existe conexión
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión a la base de datos.',
        'error' => $conn->connect_error
    ]);
    exit;
}

$conn->set_charset("utf8mb4");
?>