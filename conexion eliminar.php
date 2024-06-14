<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "ABP";

$conectar = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conectar->connect_error) {
    die("Conexión fallida - ERROR de conexión: " . $conectar->connect_error);
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['eliminar_cuenta'])){
        $correo = $_POST['correo'];
        $contra = $_POST['contra'];
        $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND contra='$contra'";
        $result = $conectar->query($sql); 
        if ($result->num_rows > 0) {
            $sql_delete = "DELETE FROM usuarios WHERE correo='$correo'";
            if ($conectar->query($sql_delete) === TRUE) {
                header("Location: inicio.html");
            } else {
                echo "Error al eliminar la cuenta: " . $conectar->error;
            }
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    } else {
        echo "No se ha enviado el formulario de eliminar cuenta.";
    }
}

$conectar->close();
?>
