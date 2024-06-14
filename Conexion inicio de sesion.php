<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "ABP";

$conectar = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conectar->connect_error) {
    die("Conexión fallida - ERROR de conexión: " . $conectar->connect_error);
} 
$correos = $_POST['correo'];
$contra = $_POST['contra'];
$sql = "SELECT * FROM usuarios WHERE correo='$correos' AND contra='$contra'";
$result = $conectar->query($sql);
if ($result->num_rows > 0) {
    
    session_start();
    $_SESSIO['correo'] = $correos;
   
    header("Location: menu.php");
    exit;
} else {
    echo "Nombre de usuarioa o contraseña incorrectos";
}
$conectar->close();
?>