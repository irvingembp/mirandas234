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
$sql = "INSERT INTO usuarios(nombre, edad, apellido, correo, contra, tel, metodo_pago) 
        VALUES ('$nombre', '$edad', '$apellido', '$correo ', '$contra', '$tel', '$metodo_pago')";


if ($conectar->query($sql) === TRUE) {
    header("Location: menu.php");
} else {
    echo "Error al insertar el registro: " . $conectar->error;
}


$conectar->close();
?>

