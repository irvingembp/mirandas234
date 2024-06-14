<?php
require 'bd.php'; // Incluye el archivo de conexión a la base de datos

// Si se envía una solicitud POST para modificar la cantidad de un producto en el carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $item_id = $_POST['item_id']; // Obtiene el ID del ítem a actualizar
    $new_quantity = $_POST['new_quantity']; // Obtiene la nueva cantidad del ítem

    // Verifica si la nueva cantidad es válida (mayor que cero)
    if ($new_quantity > 0) {
        // Prepara y ejecuta la consulta para actualizar la cantidad del ítem en el carrito
        $stmt = $conn->prepare("UPDATE carrito SET cantidad = :new_quantity WHERE id = :item_id");
        $stmt->bindParam(':new_quantity', $new_quantity);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->execute();
    }
}

// Si se envía una solicitud POST para eliminar un producto del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_item'])) {
    $item_id = $_POST['item_id']; // Obtiene el ID del ítem a eliminar

    // Prepara y ejecuta la consulta para eliminar el ítem del carrito
    $stmt = $conn->prepare("DELETE FROM carrito WHERE id = :item_id");
    $stmt->bindParam(':item_id', $item_id);
    $stmt->execute();
}

// Si se envía una solicitud POST para realizar la compra
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy'])) {
    // Elimina todos los elementos del carrito al realizar la compra
    $stmt = $conn->prepare("DELETE FROM carrito");
    $stmt->execute();
    // Redirige a la página de tarjeta.html después de la compra
    header("Location: tarjeta.html");
    exit(); // Finaliza el script para evitar ejecución adicional
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>menu</title> 
    <link rel="stylesheet" href="barra.css">
    <link rel="stylesheet" href="menu.css"> 
    <link rel="stylesheet" href="cart.css"> 
    <!-- Enlaces a los estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet"> <!-- Enlace a otra hoja de estilos estilos.css -->
    <script>
        // Función para redirigir a la página seleccionada según la opción del select
        function redirectToPage() {
            var page = document.getElementById("pageSelect").value;
            switch (page) {
                case "general":
                    window.location.href = "menu.php";
                    break;
                case "bebidas":
                    window.location.href = "menu2.php";
                    break;
                case "postres":
                    window.location.href = "menu3.php";
                    break;
            }
        }

        // Función para mostrar una alerta cuando se realiza una compra con éxito
        function showSuccessAlert() {
            window.location.href = "tarjeta.html";
        }
    </script>
</head>
<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- Barra de navegación oscura -->
            <div class="container">
                <a href="menu.php" class="navbar-brand"><strong>Productos</strong></a> <!-- Título de la marca -->
                <div class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- Barra de navegación interna -->
                    <div class="container">
                        <select id="pageSelect" onchange="redirectToPage()" class="form-select me-2"> <!-- Selección de página -->
                            <option value="">Categorias...</option>
                            <option value="general">General</option>
                            <option value="bebidas">Bebidas</option>
                            <option value="postres">Postres</option>
                        </select>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span> <!-- Ícono del botón de navegación -->
                        </button>
                        <div class="collapse navbar-collapse" id="navbarHeader"> <!-- Contenido de la barra de navegación -->
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a href="inicio.html" class="nav-link active me-2">Cerrar sesión</a> <!-- Enlace para cerrar sesión -->
                                </li>
                                <li class="nav-item">
                                    <a href="actualizar.html" class="nav-link active me-2">Actualizar cuenta</a> <!-- Enlace para actualizar cuenta -->
                                </li>
                                <li class="nav-item">
                                    <a href="eliminar.html" class="nav-link active me-2">Eliminar cuenta</a> <!-- Enlace para eliminar cuenta -->
                                </li>
                            </ul>
                            <!-- Botón del carrito -->
                            <a href="check.php" class="btn btn-primary">Carrito<span id="num_cart" class="badge bg-secondary"></span></a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container"> <!-- Contenedor principal -->
        <?php
        //recuperacion de datos de las tablas carrito y productos
        //join nos permite asociar dos tablas de la base de datos 
        $stmt = $conn->prepare("SELECT carrito.id, productos.nombre, productos.precio, productos.imagen, carrito.cantidad 
                                FROM carrito 
                                JOIN productos ON carrito.producto_id = productos.id");
        $stmt->execute();
        // Almacenar todos los ítems del carrito en un array
        $carrito = $stmt->fetchAll();

        if (!empty($carrito)) {
            $total = 0;
            // Recorrer el array de ítems del carrito para mostrar cada uno
            foreach ($carrito as $item) {
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
                // Mostrar cada ítem del carrito con opciones para actualizar y eliminar
                echo "<div class='cart-item'>
                        <img src='imagenes/{$item['imagen']}' alt='{$item['nombre']}'> <!-- Imagen del producto -->
                        <h2>{$item['nombre']}</h2> <!-- Nombre del producto -->
                        <p>Precio: \${$item['precio']}</p> <!-- Precio del producto -->
                        <form action='' method='post'> <!-- Formulario para actualizar cantidad -->
                            <input type='hidden' name='item_id' value='{$item['id']}'>
                            <label for='quantity'>Cantidad:</label>
                            <input type='number' id='quantity' name='new_quantity' value='{$item['cantidad']}' min='1'>
                            <button type='submit' name='update_quantity'>Actualizar</button>
                        </form>
                        <form action='' method='post' style='display:inline;'> <!-- Formulario para eliminar ítem -->
                            <input type='hidden' name='item_id' value='{$item['id']}'>
                            <button type='submit' name='delete_item'>Eliminar</button>
                        </form>
                        <p>Subtotal: \${$subtotal}</p> <!-- Subtotal del producto -->
                      </div>";
            }
            // Mostrar el total del carrito y botón para realizar la compra
            echo "<div class='total'>Total: \${$total}</div>";
            echo "<form action='' method='post' onsubmit='showSuccessAlert()'> <!-- Formulario para comprar -->
                    <button type='submit' name='buy' class='buy-button'>Comprar</button>
                  </form>";
        } else {
            echo "<div class='empty-cart'>El carrito está vacío.</div>"; // Mensaje si el carrito está vacío
        }
        ?>
        <a class="cart-link" href="menu.php">Continuar comprando</a> <!-- Enlace para continuar comprando -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- Script jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> <!-- Script Popper -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script> <!-- Script Bootstrap -->
    </div>
</body>
</html>