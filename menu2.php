<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>menu</title>
    <link rel="stylesheet" href="barra.css">
    <link rel="stylesheet" href="menu.css">
    <!-- Enlaces a los estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
    <script>
        // Función de JavaScript para redirigir a diferentes páginas según la opción seleccionada en el dropdown
        function redirectToPage() {
            var page = document.getElementById("pageSelect").value;
            switch (page) {
                case "home":
                    window.location.href = "menu.php";
                    break;
                case "about":
                    window.location.href = "menu2.php";
                    break;
                case "contact":
                    window.location.href = "menu3.php";
                    break;
            }
        }

        // Función para mostrar una alerta cuando se agrega un producto al carrito
        function compra() {
            alert("Producto agregado al carrito.");
        }
    </script>
</head>
<body>
<header>
    <!-- Barra de navegación -->
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand"><strong>Productos</strong></a>
            <!-- Dropdown para selección de categorías -->
            <div class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <select id="pageSelect" onchange="redirectToPage()" class="form-select me-2">
                        <option value="#">Categorias...</option>
                        <option value="home">General</option>
                        <option value="about">Bebidas</option>
                        <option value="contact">Postres</option>
                    </select>
                    <!-- Botón para navegación móvil -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- Menú de navegación -->
                    <div class="collapse navbar-collapse" id="navbarHeader">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="inicio.html" class="nav-link active me-2">Cerrar sesión</a>
                            </li>
                            <li class="nav-item">
                                <a href="pe4.html" class="nav-link active me-2">Ayuda</a>
                            </li>
                            <li class="nav-item">
                                <a href="actualizar.html" class="nav-link active me-2">Actualizar cuenta</a>
                            </li>
                            <li class="nav-item">
                                <a href="eliminar.html" class="nav-link active me-2">Eliminar cuenta</a>
                            </li>
                        </ul>
                        <!-- Botón del carrito de compras -->
                        <a href="cart.php" class="btn btn-primary">Carrito<span id="num_cart" class="badge bg-secondary"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <!-- Grid de productos usando Bootstrap -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            // Incluir el archivo de conexión a la base de datos
            require 'bd.php';

            // Preparar y ejecutar la consulta para obtener todos los productos
            //y se le agrega where para que solo los productos con categoria 2 aparezcan
            $stmt = $conn->prepare("SELECT * FROM productos WHERE id_categoria=2");
            $stmt->execute();
            
            // Almacenar todos los productos en un array
            $productos = $stmt->fetchAll();

            // Recorrer el array de productos para mostrar cada uno en una tarjeta
            foreach ($productos as $producto) {
                echo "<div class='col'>
                        <div class='card h-100 d-flex flex-column'>
                            <img src='imagenes/{$producto['imagen']}' class='card-img-top' alt='{$producto['nombre']}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$producto['nombre']}</h5>
                                <p class='card-text'>Precio: \${$producto['precio']}</p>
                            </div>
                            <div class='card-footer d-flex justify-content-between'>
                                <a href='detalles.php?id={$producto['id']}' class='btn btn-primary'>Detalles</a>
                                <form action='agregar_cart.php' method='post' class='d-inline'>
                                    <input type='hidden' name='id' value='{$producto['id']}'>
                                    <button type='submit' class='btn btn-success' onclick='compra()'>Agregar al carrito</button>
                                </form>
                            </div>
                        </div>
                      </div>";
            }
            ?>
        </div>
    </div>
</main>
<!-- Incluir Bootstrap JS y sus dependencias -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>