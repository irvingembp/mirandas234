<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "ABP";

$conectar = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conectar->connect_error) {
    die("Conexión fallida - ERROR de conexión: " . $conectar->connect_error);
} 
$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$apellido = $_POST['ape'];
$correo = $_POST['correo'];
$contra = $_POST['contra'];
$tel = $_POST['tel'];
$metodo_pago = $_POST['met'];
$sql = "UPDATE usuarios SET nombre='$nombre', edad='$edad', apellido='$apellido', contra='$contra', tel='$tel', metodo_pago='$metodo_pago' WHERE correo='$correo'" ;

if ($conectar->query($sql) === TRUE) {
    header("Location: inicio.html");
} 

$conectar->close();
?>