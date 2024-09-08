<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario_nombre = $_SESSION['usuario_nombre'] ?? null;
// Calcular la cantidad total de productos en el carrito
$total_cantidad_carrito = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $cantidad) {
        $total_cantidad_carrito += $cantidad;
    }
}
?>

<!-- Inicio del header -->
<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center">
                <p class="mb-0 phone pl-md-2">
                    <a href="#" class="mr-2"><span class="fa fa-phone mr-1"></span> 968 204 147</a> 
                    <a href="contact.php"><span class="fa fa-paper-plane mr-1"></span> contacto@taytafermentos.com.pe</a>
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end">
                <div class="social-media mr-4">
                    <p class="mb-0 d-flex">
                        <a href="https://www.facebook.com/taytafermentos/" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
                        <a href="https://www.instagram.com/taytafermentos/?hl=es" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
                    </p>
                </div>
                <div class="reg">
                    <p class="mb-0">
                        <?php if ($usuario_nombre): ?>
                            <span>Hola, <?php echo htmlspecialchars($usuario_nombre); ?> | </span>
                            <a href="dashboard.php">Mi Cuenta</a> | 
                            <a href="logout.php">Salir</a>
                        <?php else: ?>
                            <a href="login.php">Iniciar sesión</a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navegación -->
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="images/LogoSinFondo.png" width="200" height="80"></a>
        <div class="order-lg-last btn-group">
            <button onclick="openCartSidebar()" class="btn-cart dropdown-toggle dropdown-toggle-split" style="border: none; background: none;">
                <img src="images/carrito_final.png" alt="carrito de compras" style="width: 24px; height: 24px;">
                <?php if (isset($total_cantidad_carrito) && $total_cantidad_carrito > 0): ?>
                    <span class="badge badge-pill badge-danger" style="position: relative; top: -10px; right: 10px;">
                        <?php echo $total_cantidad_carrito; ?>
                    </span>
                <?php endif; ?>
            </button>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="about.php" class="nav-link">Nosotros</a></li>
                <li class="nav-item"><a href="product.php" class="nav-link">Productos</a></li>
                <li class="nav-item"><a href="cart.php" class="nav-link">Mi Carrito</a></li>
                <li class="nav-item"><a href="blog.php" class="nav-link">Membresía</a></li>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contactos</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Fin del header -->
