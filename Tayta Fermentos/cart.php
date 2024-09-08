<?php
session_start();
include('db.php'); 

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_GET['add'])) {
    $id_producto = (int)$_GET['add'];

    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto]++; 
    } else {
        $_SESSION['carrito'][$id_producto] = 1; 
    }

    header('Location: cart.php');
    exit;
}

if (isset($_POST['update_quantity'])) {
    foreach ($_POST['cantidad'] as $id_producto => $cantidad) {
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto] = (int)$cantidad; 
        }
    }

    header('Location: cart.php');
    exit;
}

$total = 0;
$descuento = 0;
$error_cupon = '';

$productos_carrito = $_SESSION['carrito'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mi Carrito - Tayta Fermentos</title>
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
								foreach ($productos_carrito as $id_producto => $cantidad):
									$query = "SELECT titulo, precio, descrpcion as descripcion, i.nombre as ruta_imagen FROM producto p 
											LEFT JOIN imagenproducto i ON p.codigo = i.producto_codigo
											WHERE p.codigo = $id_producto";
									$result = $conn->query($query);
									if ($result && $row = $result->fetch_assoc()):
										$subtotal = $row['precio'] * $cantidad;
										$total += $subtotal; 
								?>
								<tr class="alert" role="alert">
									<td>
										<label class="checkbox-wrap checkbox-primary">
											<input type="checkbox" checked>
											<span class="checkmark"></span>
										</label>
									</td>
									<td>
										<div class="img" style="background-image: url(<?php echo $row['ruta_imagen']; ?>); background-size: contain;"></div>
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
						<button type="submit" name="update_quantity" class="btn btn-primary">Actualizar Carrito</button>
					</form>
				</div>
			</div>

			<?php

			if (isset($_POST['aplicar_cupon']) && !empty($_POST['codigo_cupon'])) {
				$codigo_cupon = $_POST['codigo_cupon'];

				$query_cupon = "SELECT * FROM cupon WHERE nombre = '$codigo_cupon' AND fechaExpiracion > NOW()";
				$result_cupon = $conn->query($query_cupon);

				if ($result_cupon && $result_cupon->num_rows > 0) {
					$cupon = $result_cupon->fetch_assoc();

					if ($total >= $cupon['montoMinimo']) {
						if ($cupon['tipo'] == 'fijo') {
							$descuento = $cupon['valor'];
						} elseif ($cupon['tipo'] == 'porcentaje') {
							$descuento = ($cupon['valor'] / 100) * $total;
						}
					} else {
						$error_cupon = "El total del carrito no cumple con el monto mínimo de S/ " . number_format($cupon['montoMinimo'], 2);
					}
				} else {
					$error_cupon = "Cupón inválido o expirado.";
				}
			}

			?>
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
						<?php if ($error_cupon): ?>
							<p class="text-danger mt-2"><?php echo $error_cupon; ?></p>
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