<?php

class ProductModel {
    private $conn;

    // Constructor que recibe la conexión
    public function __construct($connection) {
        $this->conn = $connection;
    }

    // Obtener todas las bodegas
    public function getBodegas() {
        $sql = "SELECT id, nombre FROM bodegas ORDER BY nombre";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Obtener sucursales por bodega
    public function getSucursalesByBodega($bodega_id) {
        $sql = "SELECT id, nombre FROM sucursales WHERE bodega_id = ? ORDER BY nombre";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $bodega_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    // Obtener todas las monedas
    public function getMonedas() {
        $sql = "SELECT id, nombre FROM monedas ORDER BY nombre";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Verificar si el código ya existe
    public function codigoExiste($codigo) {
        $sql = "SELECT COUNT(*) as count FROM productos WHERE codigo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] > 0;
    }

    // Insertar nuevo producto
    public function insertarProducto($data) {
        $sql = "INSERT INTO productos (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, descripcion, materiales) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $materiales = implode(', ', $data['materiales']);

        $stmt->bind_param(
            "ssisssds",
            $data['codigo'],
            $data['nombre'],
            $data['bodega_id'],
            $data['sucursal_id'],
            $data['moneda_id'],
            $data['precio'],
            $data['descripcion'],
            $materiales
        );

        $success = $stmt->execute();
        $error = $success ? '' : $stmt->error;
        $stmt->close();

        return ['success' => $success, 'error' => $error];
    }
}
?>