<?php
// Conectar a la base de datos (puedes ajustar los valores según tu configuración)
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "ABP";
$conectar = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conectar->connect_error) {
    die("Conexión fallida - ERROR de conexión: " . $conectar->connect_error);
} 

$nombre = $_POST['nombre'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$CVV = $_POST['CVV'];
$pa = $_POST['pa'];

// Uso de consultas preparadas para prevenir inyecciones SQL
$stmt = $conectar->prepare("INSERT INTO tarjetas (nombre, fecha_vencimiento, CVV, pais) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $fecha_vencimiento, $CVV, $pa);

    header("Location: menu.php");

$stmt->close();
$conectar->close();
?>