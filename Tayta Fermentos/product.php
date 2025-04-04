
<?php
include('db.php'); 

// Obtener categorías para el filtro
$query_categoria = "SELECT * FROM categoria";
$result_categoria = $conn->query($query_categoria);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Productos - Tayta Fermentos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Spectral:ital,wght@0,200;0,300;0,400;0,500;0,700;0,800;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  </head>
  <body>

  <?php include('header.php'); ?>    
    
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row mb-4">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <!-- Select para ordenar productos -->
                            <form id="ordenarForm" method="GET" class="form-inline">
                                <label for="ordenar" class="mr-2">Ordenar por:</label>
                                <select name="ordenar" id="ordenar" class="form-control" onchange="document.getElementById('ordenarForm').submit();">
                                    <option value="">Seleccione</option>
                                    <option value="precio_mayor" <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'precio_mayor') ? 'selected' : ''; ?>>Precio de Mayor a Menor</option>
                                    <option value="precio_menor" <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'precio_menor') ? 'selected' : ''; ?>>Precio de Menor a Mayor</option>
                                    <option value="a_z" <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'a_z') ? 'selected' : ''; ?>>Orden de A a Z</option>
                                    <option value="z_a" <?php echo (isset($_GET['ordenar']) && $_GET['ordenar'] == 'z_a') ? 'selected' : ''; ?>>Orden de Z a A</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <?php

                            $orden = $_GET['ordenar'] ?? '';
                            $orderBy = '';
                            switch ($orden) {
                                case 'precio_mayor':
                                    $orderBy = 'ORDER BY p.precio DESC';
                                    break;
                                case 'precio_menor':
                                    $orderBy = 'ORDER BY p.precio ASC';
                                    break;
                                case 'a_z':
                                    $orderBy = 'ORDER BY p.titulo ASC';
                                    break;
                                case 'z_a':
                                    $orderBy = 'ORDER BY p.titulo DESC';
                                    break;
                                default:
                                    $orderBy = '';
                                    break;
                            }

                            $query_productos = "SELECT p.codigo, p.titulo, p.precio, p.descrpcion, i.nombre as ruta, c.nombre AS categoria, p.slug 
                                                FROM producto p
                                                LEFT JOIN imagenproducto i ON p.codigo = i.producto_codigo
                                                LEFT JOIN categoria c ON p.codigoCategoria = c.codigo 
                                                $orderBy";                            
                            $result_productos = $conn->query($query_productos);
                        ?>
                        <?php while ($row = $result_productos->fetch_assoc()): ?>
                        <!-- Comienzo de la tarjeta de producto -->
                        <div class="col-md-4 d-flex">
                            <div class="product ftco-animate">
                                <div class="img d-flex align-items-center justify-content-center" style="background-image: url(<?php echo $row['ruta']; ?>); background-size: contain;">
                                    <div class="desc">
                                        <p class="meta-prod d-flex">
                                            <a href="#" class="d-flex align-items-center justify-content-center" onclick="addToCart(<?php echo $row['codigo']; ?>); return false;">
                                                <span class="flaticon-shopping-bag"></span>
                                            </a>
                                            <a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-heart"></span></a>
                                            <a href="product-single.php?id=<?php echo $row['codigo']; ?>" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
                                        </p>
                                    </div>
                                </div>
                                <div class="text text-center">
                                    <span class="category"><?php echo htmlspecialchars($row['categoria']); ?></span>
                                    <h2><?php echo htmlspecialchars($row['titulo']); ?></h2>
                                    <span class="price">S/ <?php echo number_format($row['precio'], 2); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Sección de paginación -->
                    <div class="row mt-5">
                        <div class="col text-center">
                            <div class="block-27">
                                <ul>
                                    <li><a href="#">&lt;</a></li>
                                    <li class="active"><span>1</span></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a href="#">&gt;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <!-- Aquí va la barra lateral (sidebar) -->
                    <?php include('sidebar.php'); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Barra lateral del carrito -->
    <div id="cart-sidebar">
        <span class="closebtn" onclick="closeCartSidebar()">&times;</span>
        <h3>Tu Carrito</h3>
        <div id="cart-items">
            <?php include 'cart_items.php'; ?>
        </div>
        <div class="cart-footer">
            <a href="cart.php" class="btn btn-secondary">Ver Carrito</a>
            <a href="checkout.php" class="btn btn-primary">Proceder al Pago</a>
        </div>
    </div>

    <a href="https://wa.me/968204147" target="_blank" class="whatsapp">
        <img src="images/whats.png" alt="WhatsApp" class="whatsapp-icon">
    </a>

		
    <?php include('footer.php'); ?>    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>