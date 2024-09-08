<?php
session_start();
include('db.php'); 

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$productos_carrito = $_SESSION['carrito'];
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['optradio'] == 'Tarjeta') {
        $_SESSION['checkout_data'] = [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'country' => $_POST['country'],
            'streetaddress' => $_POST['streetaddress'],
            'towncity' => $_POST['towncity'],
            'postcodezip' => $_POST['postcodezip'],
            'phone' => $_POST['phone'],
            'emailaddress' => $_POST['emailaddress'],
            'dni' => $_POST['dni'],
            'codigoDistrito' => $_POST['codigoDistrito'],
            'total' => $_POST['total'], 
        ];
    }
}
*/
$total = 0;

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
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  </head>
  <body>

  <?php include('header.php'); ?>   
    <!-- END nav -->
    
    

    <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-12 ftco-animate">
					<!-- Un solo formulario que incluye Datos de Facturación y Métodos de Pago -->
					<form action="confirm.php" method="POST" class="billing-form">
						<div class="row">
							<!-- Columna Izquierda: Formulario de Datos de Facturación -->
							<div class="col-xl-6">
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
											<label for="document">Tipo Documento</label>
											<div class="select-wrap">
												<div class="icon"><span class="ion-ios-arrow-down"></span></div>
												<select name="document" class="form-control" required>
													<option value="">Seleccione</option>
													<option value="dni">DNI</option>
													<option value="pasaporte">Pasaporte</option>
													<option value="carnet">Carnet Extranjería</option>
													<option value="ruc">RUC</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="dni">Número Doc.</label>
											<input type="text" class="form-control" name="dni">
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="tipo_compra">Tipo de Compra</label>
											<select name="tipo_compra" id="tipo_compra" class="form-control" required>
												<option value="retiro">Retiro en tienda</option>
												<option value="delivery">Delivery</option>												
											</select>
										</div>
									</div>
									
									<div class="w-100"></div>
									<div id="campos_direccion" class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="departamento">Departamento</label>
												<select name="departamento" id="departamento" class="form-control" required>
													<option value="">Seleccione</option>
													<?php
													$query_departamentos = "SELECT codigo, nombre FROM departamento";
													$result_departamentos = $conn->query($query_departamentos);
													while ($row = $result_departamentos->fetch_assoc()):
													?>
													<option value="<?php echo $row['codigo']; ?>"><?php echo $row['nombre']; ?></option>
													<?php endwhile; ?>
												</select>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="provincia">Provincia</label>
												<select name="provincia" id="provincia" class="form-control" required>
													<option value="">Seleccione</option>
												</select>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="distrito">Distrito</label>
												<select name="distrito" id="distrito" class="form-control" required>
													<option value="">Seleccione</option>
												</select>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="streetaddress">Dirección</label>
												<input type="text" class="form-control" name="streetaddress" required>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="streetreference">Referencia</label>
												<input type="text" class="form-control" name="streetreference" placeholder="Apartamento, suite, unidad etc: (opcional)">
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Columna Derecha: Total Compras y Métodos de Pago -->
							<div class="col-xl-6">
								<!-- Total Compras -->
								<div class="cart-detail cart-total p-3 p-md-4 mb-4">
									<h3 class="billing-heading mb-4">Total Compras</h3>
									<?php 
									$subtotal = 0; 
									$descuento = 0;
									foreach ($productos_carrito as $id_producto => $cantidad):
										// Obtener detalles del producto desde la base de datos
										$query = "SELECT titulo, precio FROM producto WHERE codigo = $id_producto";
										$result = $conn->query($query);
										if ($result && $row = $result->fetch_assoc()):
											$subtotal_producto = $row['precio'] * $cantidad;
											$subtotal += $subtotal_producto; ?>
											<p class="d-flex">
												<span><?php echo $row['titulo']; ?> x <?php echo $cantidad; ?></span>
												<span>S/ <?php echo number_format($subtotal_producto, 2); ?></span>
											</p>
									<?php endif; endforeach; ?>
									
									<hr>
									<p class="d-flex">
										<span>Subtotal</span>
										<span id="subtotal" data-subtotal="<?php echo $subtotal; ?>">S/ <?php echo number_format($subtotal, 2); ?></span>
									</p>
									<p class="d-flex">
										<span>Delivery</span>
										<span id="costo_delivery">S/ 0.00</span>
									</p>
									<p class="d-flex">
										<span>Descuento</span>
										<span id="descuento">S/ <?php echo number_format($descuento, 2); ?></span>
									</p>
									<hr>
									<p class="d-flex total-price">
										<span>Total</span>
										<span id="total">S/ <?php echo number_format($subtotal - $descuento, 2); ?></span>
									</p>
									<input type="hidden" name="total" value="<?php echo $subtotal - $descuento; ?>">
								</div>

								<!-- Métodos de Pago -->
								<div class="cart-detail p-3 p-md-4">
									<h3 class="billing-heading mb-4">Método de Pago</h3>
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
												<label><input type="radio" name="optradio" value="Tarjeta" id="payment-card" required> Tarjeta de Crédito/Débito</label>
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
									<button type="submit" id="submit-button" class="btn btn-primary py-3 px-4">Realizar Pedido</button>
								</div>
							</div>
						</div>
					</form>
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
  <script src="js/main.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script>
	document.getElementById('departamento').addEventListener('change', function() {
		var departamentoId = this.value;
		fetch('get_provincias.php?departamento_id=' + departamentoId)
			.then(response => response.json())
			.then(data => {
				var provinciaSelect = document.getElementById('provincia');
				provinciaSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
				data.forEach(function(provincia) {
					var option = document.createElement('option');
					option.value = provincia.codigo;
					option.textContent = provincia.nombre;
					provinciaSelect.appendChild(option);
				});
				document.getElementById('distrito').innerHTML = '<option value="">Seleccione</option>'; // Reset distritos
			});
	});

	document.getElementById('provincia').addEventListener('change', function() {
		var provinciaId = this.value;
		fetch('get_distritos.php?provincia_id=' + provinciaId)
			.then(response => response.json())
			.then(data => {
				var distritoSelect = document.getElementById('distrito');
				distritoSelect.innerHTML = '<option value="">Seleccione</option>';
				data.forEach(function(distrito) {
					var option = document.createElement('option');
					option.value = distrito.codigo;
					option.textContent = distrito.nombre;
					distritoSelect.appendChild(option);
				});
			});
	});


	// Configuración para la pasarela de pagos de Stripe
	var stripe = Stripe('pk_test_51PvTtwApp0UZS128stCfkolxx2O7woHsUcWSCYEAO6z7kfMlbDDYYblEsamW00kUntDedQvV6q3tn1MI26xbqS4l00xXJ0FCPI');

    document.getElementById('submit-button').addEventListener('click', function(e) {
        e.preventDefault(); 

        var selectedPaymentMethod = document.querySelector('input[name="optradio"]:checked').value;

        if (selectedPaymentMethod === 'Tarjeta') {
            fetch('create_checkout_session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    total: <?php echo $total; ?>
                })
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(session) {
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function(result) {
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function(error) {
                console.error('Error al crear la sesión de pago:', error);
            });
        } else {
            document.querySelector('.billing-form').submit();
        }
    });


	
  </script>
  </body>
</html>