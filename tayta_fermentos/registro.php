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
    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  </head>
  <body>

  	<?php include('header.php'); ?>  
    <!-- END nav -->
    
	<section class="ftco-section bg-light min-h-screen flex items-center justify-center" style="margin-top: 20px;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7">
					<div class="contact-wrap w-100 p-md-5 p-4 text-center mx-auto">

						<div class="mb-4">
							<p class="text-center mb-3">Elija una opción para registrarse:</p>
							<div class="row">
								<div class="col mb-2">
									<button type="button" class="btn btn-primary btn-block mx-auto" style="max-width: 300px;">
										<img src="images/google.png" alt="Google" style="width: 25px; margin-right: 10px;"> Ingresar con Google
									</button>
								</div>
								<div class="col">
									<button type="button" class="btn btn-primary btn-block mx-auto" style="max-width: 300px;">
										<img src="images/facebook.png" alt="Facebook" style="width: 25px; margin-right: 10px;"> Ingresar con Facebook
									</button>
								</div>
							</div>
						</div>

						<h3 class="mb-4">Crear Cuenta</h3>

						<?php if (isset($_GET['error'])): ?>
							<div class="alert alert-danger">
								<?php
								if ($_GET['error'] === 'correo_existe') {
									echo "Este correo electrónico ya está registrado.";
								} elseif ($_GET['error'] === 'error_db') {
									echo "Error al registrar el usuario. Intente de nuevo.";
								} elseif ($_GET['error'] === 'campos_vacios') {
									echo "Por favor, completa todos los campos.";
								}
								?>
							</div>
						<?php endif; ?>

						<form action="procesar_registro.php" method="POST" class="text-center mx-auto">
							<div data-mdb-input-init class="form-outline mb-4 text-left mx-auto" style="max-width: 300px;">
								<input type="text" id="formName" name="nombre" class="form-control" placeholder="Ej.: Juan Pérez" required />
								<label class="form-label" for="formName">Nombre Completo</label>
							</div>

							<div data-mdb-input-init class="form-outline mb-4 text-left mx-auto" style="max-width: 300px;">
								<input type="email" id="form2Example1" name="email" class="form-control" placeholder="Ej.: ejemplo@mail.com" required />
								<label class="form-label" for="form2Example1">Correo</label>
							</div>

							<div data-mdb-input-init class="form-outline mb-4 text-left mx-auto" style="max-width: 300px;">
								<input type="password" id="form2Example2" name="password" class="form-control" placeholder="Ingrese su contraseña" required />
								<label class="form-label" for="form2Example2">Contraseña</label>
							</div>

							<div data-mdb-input-init class="form-outline mb-4 text-left mx-auto" style="max-width: 300px;">
								<input type="password" id="formConfirmPassword" name="confirm_password" class="form-control" placeholder="Confirme su contraseña" required />
								<label class="form-label" for="formConfirmPassword">Confirmar Contraseña</label>
							</div>

							<button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4 mx-auto" style="max-width: 300px;">Registrarse</button>
						</form>

						<p class="mt-4">¿Ya tienes una cuenta? <a href="login.php" class="text-primary">Inicia Sesión</a></p>
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
  <script src="js/main.js"></script>
    
  </body>
</html>