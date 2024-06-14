<?php
require 'bd.php';
// Verificamos si se envió una solicitud POST y si existe el parámetro 'id'
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $producto_id = $_POST['id'];
    // Verificamos si el producto ya está en el carrito
    $stmt = $conn->prepare("SELECT * FROM carrito WHERE producto_id = :producto_id");
    $stmt->bindParam(':producto_id', $producto_id);
    $stmt->execute();
    $producto_en_carrito = $stmt->fetch();
    // Si el producto ya está en el carrito, incrementamos la cantidad
    if ($producto_en_carrito) {
        $stmt = $conn->prepare("UPDATE carrito SET cantidad = cantidad + 1 WHERE producto_id = :producto_id");
    } else {
        // Si el producto no está en el carrito, lo insertamos con cantidad 1
        $stmt = $conn->prepare("INSERT INTO carrito (producto_id, cantidad) VALUES (:producto_id, 1)");
    }
   
    $stmt->bindParam(':producto_id', $producto_id);
    $stmt->execute();
    header("Location: menu.php");
    
}
?>