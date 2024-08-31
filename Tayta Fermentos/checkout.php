<?php
session_start();
include('db.php'); // Conexión a la base de datos

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Capturar y validar la información del formulario al enviar la orden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
    // Datos del cliente
    $nombres = $_POST['firstname'] ?? '';
    $apellidos = $_POST['lastname'] ?? '';
    $email = $_POST['emailaddress'] ?? '';
    $genero = $_POST['gender'] ?? '';  
    $dni = $_POST['dni'] ?? '';       
    $celular = $_POST['phone'] ?? '';
    $direccion_cliente = $_POST['streetaddress'] ?? '';
    $codigoDistrito = $_POST['codigoDistrito'] ?? '';

    // Datos del pedido
    $direccion_envio = $_POST['streetaddress'] ?? ''; 
    $observacion = $_POST['observacion'] ?? '';
    $metodo_pago = $_POST['optradio'];
    $total = $_POST['total']; // Total calculado del carrito

	if ($nombres && $apellidos && $email && $celular && $direccion_cliente && $codigoDistrito) {

		// Guardar el cliente en la tabla cliente
		$query_cliente = "INSERT INTO cliente (nombre, apellido, email, genero, dni, celular, direccion, codigoDistrito)
						VALUES ('$nombres', '$apellidos', '$email', '$genero', '$dni', '$celular', '$direccion_cliente', $codigoDistrito)";
		
		if ($conn->query($query_cliente)) {
			// Obtener el ID del cliente recién insertado
			$codigoCliente = $conn->insert_id;

			// Generar un número de pedido único
			$numero_pedido = 'PED-' . time();

			// Guardar el pedido en la tabla pedido
			$query_pedido = "INSERT INTO pedido (numero, fecha, direccion, observacion, codigoCliente, codigoDistrito, transaccionCodigo)
							VALUES ('$numero_pedido', NOW(), '$direccion_envio', '$observacion', $codigoCliente, $codigoDistrito, $metodo_pago)";

			if ($conn->query($query_pedido)) {
				// Obtener el ID del pedido recién insertado
				$codigoPedido = $conn->insert_id;

				// Guardar los detalles del pedido en la tabla detallepedido
				foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
					// Obtener detalles del producto
					$query_producto = "SELECT titulo, precio FROM producto WHERE codigo = $id_producto";
					$result_producto = $conn->query($query_producto);
					if ($result_producto && $row = $result_producto->fetch_assoc()) {
						$precioUnitario = $row['precio'];
						$descripcion = $row['titulo'];

						$query_detalle = "INSERT INTO detallepedido (cantidad, precioUnitario, descripcion, pedido_codigo, presentacion_codigo)
										VALUES ($cantidad, $precioUnitario, '$descripcion', $codigoPedido, $id_producto)";
						$conn->query($query_detalle);
					}
				}

				// Limpiar el carrito después de procesar la orden
				$_SESSION['carrito'] = [];
				header('Location: confirm.php'); // Redirigir a una página de confirmación
				exit;
			} else {
				$error = "Hubo un error al procesar su pedido. Por favor, inténtelo de nuevo.";
			}
		} else {
			$error = "Hubo un error al guardar los datos del cliente. Por favor, inténtelo de nuevo.";
		}
	} else {
		$error = "Por favor, complete todos los campos requeridos.";
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
    
    

    <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<!-- Columna Izquierda: Formulario de Datos de Facturación -->
				<div class="col-xl-6 ftco-animate">
					<form action="checkout.php" method="POST" class="billing-form">
						<h3 class="mb-4 billing-heading">Detalles de Facturación</h3>
						<div class="row align-items-end">
							<div class="col-md-6">
								<div class="form-group">
									<label for="firstname">Nombres</label>
									<input type="text" class="form-control" name="firstname" id="firstname" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="lastname">Apellidos</label>
									<input type="text" class="form-control" name="lastname" id="lastname" required>
								</div>
							</div>
							<div class="w-100"></div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="country">País</label>
									<div class="select-wrap">
										<div class="icon"><span class="ion-ios-arrow-down"></span></div>
										<select name="country" class="form-control" required>
											<option value="Perú">Perú</option>
											<!-- Otros países si es necesario -->
										</select>
									</div>
								</div>
							</div>
							<div class="w-100"></div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="streetaddress">Dirección</label>
									<input type="text" class="form-control" name="streetaddress" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Apartamento, suite, unidad etc: (opcional)">
								</div>
							</div>
							<div class="w-100"></div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="towncity">Ciudad</label>
									<input type="text" class="form-control" name="towncity" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="postcodezip">Código Postal</label>
									<input type="text" class="form-control" name="postcodezip" required>
								</div>
							</div>
							<div class="w-100"></div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="phone">Celular</label>
									<input type="text" class="form-control" name="phone" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="emailaddress">Correo</label>
									<input type="email" class="form-control" name="emailaddress" required>
								</div>
							</div>
							<div class="w-100"></div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="dni">DNI</label>
									<input type="text" class="form-control" name="dni">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="codigoDistrito">Distrito</label>
									<input type="text" class="form-control" name="codigoDistrito" required>
								</div>
							</div>
						</div>

						<!-- Mostrar errores si existen -->
						<?php if (isset($error)): ?>
							<p class="text-danger"><?php echo $error; ?></p>
						<?php endif; ?>
					</form>
				</div>

				<!-- Columna Derecha: Total Compras y Métodos de Pago -->
				<div class="col-xl-6 d-flex flex-column">
					<!-- Total Compras -->
					<div class="cart-detail cart-total p-3 p-md-4 mb-4">
						<h3 class="billing-heading mb-4">Total Compras</h3>
						<?php foreach ($productos_carrito as $id_producto => $cantidad):
							// Obtener detalles del producto desde la base de datos
							$query = "SELECT titulo, precio FROM producto WHERE codigo = $id_producto";
							$result = $conn->query($query);
							if ($result && $row = $result->fetch_assoc()):
								$subtotal = $row['precio'] * $cantidad;
								$total += $subtotal; ?>
								<p class="d-flex">
									<span><?php echo $row['titulo']; ?> x <?php echo $cantidad; ?></span>
									<span>S/ <?php echo number_format($subtotal, 2); ?></span>
								</p>
						<?php endif; endforeach; ?>
						<hr>
						<p class="d-flex total-price">
							<span>Total</span>
							<span>S/ <?php echo number_format($total, 2); ?></span>
						</p>
					</div>

					<!-- Métodos de Pago -->
					<div class="cart-detail p-3 p-md-4">
						<h3 class="billing-heading mb-4">Método de Pago</h3>
						<form action="checkout.php" method="POST">
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									<label><input type="radio" name="optradio" value="Transferencia" required> Transferencia</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									<label><input type="radio" name="optradio" value="Tarjeta" required> Tarjeta de Crédito/Débito</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="radio">
									<label><input type="radio" name="optradio" value="Yape/Plin" required> Yape / Plin</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="checkbox">
									<label><input type="checkbox" value="" required> He leído y acepto los términos y condiciones</label>
									</div>
								</div>
							</div>
							<input type="hidden" name="total" value="<?php echo $total; ?>">
							<button type="submit" class="btn btn-primary py-3 px-4">Realizar Pedido</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

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