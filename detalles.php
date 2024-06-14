<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
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
                    window.location.href = "inicio.html";
                    break;
                default:
                    window.location.href = "actualizar.html";
            }
        }
    </script>
</head>
<body>
<header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="menu.php" class="navbar-brand"><strong>Productos</strong></a>
            <div class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <select id="pageSelect" onchange="redirectToPage()" class="form-select me-2">
                        <option value="">Categorias...</option>
                        <option value="home">General</option>
                        <option value="about">Bebidas</option>
                        <option value="contact">Postres</option>
                    </select>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarHeader">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="inicio.html" class="nav-link active me-2">Cerrar sesión</a>
                            </li>
                            <li class="nav-item">
                                <a href="actualizar.html" class="nav-link active me-2">Actualizar cuenta</a>
                            </li>
                            <li class="nav-item">
                                <a href="eliminar.html" class="nav-link active me-2">Eliminar cuenta</a>
                            </li>
                        </ul>
                        <a href="check.php" class="btn btn-primary">Carrito<span id="num_cart" class="badge bg-secondary"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <div class="row">
            <?php
            require 'bd.php';

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $id = $_GET['id'];

                $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
                $stmt->execute([$id]);
                $producto = $stmt->fetch();

                if ($producto) {
                    $imagen_principal = 'imagenes/' . $producto['imagen'];
                    $nombre = $producto['nombre'];
                    $descripcion = $producto['descripcion'];
                    $precio = $producto['precio'];

                    echo "<div class='col-md-6 order-md-1'>
                            <img src='{$imagen_principal}' class='img-fluid' alt='{$nombre}'>
                        </div>
                        <div class='col-md-6 order-md-2'>
                            <h2>{$nombre}</h2>
                            <p>{$descripcion}</p>
                            <h4>Precio: \${$precio}</h4>
                            <form action='agregar_cart.php' method='post'>
                                <input type='hidden' name='id' value='{$id}'>
                                <button type='submit' class='btn btn-primary'>Agregar al carrito</button>
                            </form>
                        </div>";
                } else {
                    echo "<div class='col-md-12'><p class='text-center'>Producto no encontrado.</p></div>";
                }
            } else {
                echo "<div class='col-md-12'><p class='text-center'>ID de producto no proporcionado.</p></div>";
            }
            ?>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>