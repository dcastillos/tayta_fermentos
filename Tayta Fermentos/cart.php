<?php
session_start();
include('db.php'); // Conexión a la base de datos

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Capturar el ID del producto a agregar al carrito
if (isset($_GET['add'])) {
    $id_producto = (int)$_GET['add'];
    
    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto]++; // Incrementar la cantidad
    } else {
        $_SESSION['carrito'][$id_producto] = 1; // Agregar producto al carrito con cantidad 1
    }

    // Redireccionar de nuevo a la página del carrito después de agregar
    header('Location: cart.php');
    exit;
}

// Capturar la actualización de cantidades
if (isset($_POST['update_quantity'])) {
    foreach ($_POST['cantidad'] as $id_producto => $cantidad) {
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto] = (int)$cantidad; // Actualizar la cantidad en la sesión
        }
    }

    // Redireccionar de nuevo a la página del carrito después de actualizar
    header('Location: cart.php');
    exit;
}

// Inicializar variable de descuento
$descuento = 0;

// Manejar la validación del cupón
if (isset($_POST['aplicar_cupon'])) {
    $codigo_cupon = $_POST['codigo_cupon'];

    // Consulta para verificar si el cupón es válido
    $query_cupon = "SELECT * FROM cupon WHERE codigo = '$codigo_cupon' AND expiracion >= NOW()";
    $result_cupon = $conn->query($query_cupon);

    if ($result_cupon && $result_cupon->num_rows > 0) {
        $cupon = $result_cupon->fetch_assoc();
        $descuento = $cupon['descuento']; // Suponiendo que el campo 'descuento' contiene el valor de descuento en porcentaje
    } else {
        $error = "Cupón inválido o expirado.";
    }
}

// Obtener productos del carrito desde la sesión
$productos_carrito = $_SESSION['carrito'];
$total = 0; // Variable para el total del carrito

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tayta Fermentos</title>
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
  </head>
  <body>

  <?php include('header.php'); ?>   
    <!-- END nav -->
	<section class="hero-wrap hero-wrap-2" style="background-image: url('images/Fondo_blanco.jpg');" data-stellar-background-ratio="0.5">
      
	</section>
    

    <section class="ftco-section">
		<div class="container">
			<div class="row">
				<div class="table-wrap">
					<form action="cart.php" method="POST">
						<table class="table">
							<thead class="thead-primary">
								<tr>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>Productos</th>
									<th>Precio</th>
									<th>Cantidad</th>
									<th>Total</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// Iterar sobre los productos en el carrito
								foreach ($productos_carrito as $id_producto => $cantidad):
									// Obtener detalles del producto desde la base de datos
									$query = "SELECT titulo, precio, descrpcion as descripcion, i.nombre as ruta_imagen FROM producto p 
											LEFT JOIN imagenproducto i ON p.codigo = i.producto_codigo
											WHERE p.codigo = $id_producto";
									$result = $conn->query($query);
									if ($result && $row = $result->fetch_assoc()):
										$subtotal = $row['precio'] * $cantidad;
										$total += $subtotal; // Calcular el total del carrito
								?>
								<tr class="alert" role="alert">
									<td>
										<label class="checkbox-wrap checkbox-primary">
											<input type="checkbox" checked>
											<span class="checkmark"></span>
										</label>
									</td>
									<td>
										<div class="img" style="background-image: url(images/<?php echo $row['ruta_imagen']; ?>); background-size: contain;"></div>
									</td>
									<td>
										<div class="email">
											<span><?php echo $row['titulo']; ?></span>
											<span><?php echo $row['descripcion']; ?></span>
										</div>
									</td>
									<td>S/ <?php echo number_format($row['precio'], 2); ?></td>
									<td class="quantity">
										<div class="input-group">
											<input type="number" name="cantidad[<?php echo $id_producto; ?>]" class="quantity form-control input-number" value="<?php echo $cantidad; ?>" min="1" max="100">
										</div>
									</td>
									<td>S/ <?php echo number_format($subtotal, 2); ?></td>
									<td>
										<a href="remove_from_cart.php?id=<?php echo $id_producto; ?>" class="close" aria-label="Close">
											<span aria-hidden="true"><i class="fa fa-close"></i></span>
										</a>
									</td>
								</tr>
								<?php endif; endforeach; ?>
							</tbody>
						</table>
						<!-- Botón para actualizar las cantidades -->
						<button type="submit" name="update_quantity" class="btn btn-primary">Actualizar Carrito</button>
					</form>
				</div>
			</div>

			<!-- Sección de cupones y total en la misma fila -->
			<div class="row justify-content-end">
				<!-- Sección para ingresar cupones -->
				<div class="col col-lg-6 col-md-6 mt-5 cart-wrap ftco-animate">
					<div class="cart-total mb-3">
						<h3>Ingresar Cupón de Descuento</h3>
						<form action="cart.php" method="POST">
							<div class="form-group">
								<label for="codigo_cupon">Código de Cupón</label>
								<input type="text" class="form-control" name="codigo_cupon" required>
							</div>
							<button type="submit" name="aplicar_cupon" class="btn btn-primary py-3 px-4">Aplicar Cupón</button>
						</form>
						<?php if (isset($error)): ?>
							<p class="text-danger mt-2"><?php echo $error; ?></p>
						<?php endif; ?>
					</div>
				</div>

				<!-- Total del carrito -->
				<div class="col col-lg-6 col-md-6 mt-5 cart-wrap ftco-animate">
					<div class="cart-total mb-3">
						<h3>Total Compras</h3>
						<p class="d-flex">
							<span>Subtotal</span>
							<span>S/ <?php echo number_format($total, 2); ?></span>
						</p>
						<p class="d-flex">
							<span>Delivery</span>
							<span>S/ 0.00</span>
						</p>
						<p class="d-flex">
							<span>Descuento</span>
							<span>S/ <?php echo number_format(($total * $descuento) / 100, 2); ?></span>
						</p>
						<hr>
						<p class="d-flex total-price">
							<span>Total</span>
							<span>S/ <?php echo number_format($total - (($total * $descuento) / 100), 2); ?></span>
						</p>
					</div>
					<p class="text-center"><a href="checkout.php" class="btn btn-primary py-3 px-4">Finalizar Compra</a></p>
				</div>
			</div>
		</div>
	</section>

    <footer class="ftco-footer">
		<div class="container">
		  <div class="row mb-5">
			<div class="col-sm-12 col-md">
			  <div class="ftco-footer-widget mb-4">
				<h2 class="ftco-heading-2 logo"><a href="#">EMPRESA</span></a></h2>
				<p>Nutre tu cuerpo, vive mejor. Descubre nuestros productos 100% saludables.</p>
				<ul class="ftco-footer-social list-unstyled mt-2">
				  <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
				  <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
				  <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
				</ul>
			  </div>
			</div>
			
			
			<div class="col-sm-12 col-md">
			   <div class="ftco-footer-widget mb-4">
				<h2 class="ftco-heading-2">Preguntas rápidas </h2>
				<ul class="list-unstyled">
				  <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Preguntas frecuentes</a></li>
				  <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Promociones y campañas</a></li>
				  <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Política de despacho</a></li>
				  <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Política de privacidad</a></li>
				  <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Términos y condiciones</a></li>
				</ul>
			  </div>
			</div>
			<div class="col-sm-12 col-md">
			  <div class="ftco-footer-widget mb-4">
				  <h2 class="ftco-heading-2">Contáctanos</h2>
				  <div class="block-23 mb-3">
					<ul>
					  <li><span class="icon fa fa-map marker"></span><span class="text">Direccion de Tayta Fermentos</span></li>
					  <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">968 204 147</span></a></li>
					  <li><a href="#"><span class="icon fa fa-paper-plane pr-4"></span><span class="text">contacto@taytafermentos.com.pe</span></a></li>
					</ul>
				  </div>
			  </div>
			</div>
		  </div>
		</div>
		<div class="container-fluid px-0 py-5 bg-black">
			<div class="container">
				<div class="row">
				<div class="col-md-12">
		  
				  <p class="mb-0" style="color: rgba(255,255,255,.5);"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
		 &copy;<script>document.write(new Date().getFullYear());</script> Tayta Fermentos.Todos los derechos reservados 
		 <img src="images/visa_sin fondo.png" alt="Visa" style="width: 40px; margin-right: 10px;">
		 <img src="images/33333-cutout.png" alt="Master" style="width: 40px; margin-right: 10px;">
		<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
				</div>
			  </div>
			</div>
		</div>
	  </footer>
    
  

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