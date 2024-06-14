<?php
$servername = "localhost"; // Nombre del servidor de la base de datos
$username = "root"; // Nombre de usuario de la base de datos
$password = ""; // Contraseña del usuario de la base de datos
$dbname = "abp"; // Nombre de la base de datos a la que se quiere conectar

try {
    // Creación de una nueva conexión PDO a la base de datos MySQL
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Establecimiento del modo de manejo de errores para la conexión
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Manejo de excepciones en caso de fallo en la conexión
    echo "Connection failed: " . $e->getMessage();
}
?>
