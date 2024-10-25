<?php
include('db.php'); // Conexión a la base de datos

// Consulta para obtener los 4 últimos productos
$query = "SELECT p.codigo, p.titulo, p.precio, p.descrpcion as descripcion, c.nombre AS categoria, i.nombre AS ruta_imagen
          FROM producto p
          LEFT JOIN categoria c ON p.codigoCategoria = c.codigo
          LEFT JOIN imagenproducto i ON p.codigo = i.producto_codigo
          ORDER BY p.codigo DESC
          LIMIT 4";
$result = $conn->query($query);
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
    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  </head>
  <body>

  <?php include('header.php'); ?>   
    <!-- END nav -->
	 
	<!--carrusel-->
	<div class="d-flex justify-content-center" style="margin-top: 93px; margin-bottom: 20px; margin-left: 30px; margin-right: 30px;">
		<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img src="images/IMG_6314(3).png" class="d-block w-100" alt="Primera">
				</div>
				<div class="carousel-item">
					<img src="images/foto_testimonio.jpg" class="d-block w-100" alt="Segunda">
				</div>
				<div class="carousel-item">
					<img src="images/DSC01077.jpg" class="d-block w-100" alt="Tercero">
				</div>
				<div class="carousel-item">
					<img src="images/IMG_6266.jpg" class="d-block w-100" alt="cuarta">
				</div>
			</div>
			<a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span> 
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span></a>
		</div>
	</div>
  
  
    
	
    <section class="ftco-intro">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-4 d-flex">
    				<div class="intro d-lg-flex w-100 ftco-animate">
    					<div class="icon">
    						<span class="flaticon-support"></span>
    					</div>
    					<div class="text">
    						<h2>DESCUBRE NUESTRO TALLERES</h2>
    						<p>En nuestros talleres, te invitamos a descubrir el fascinante mundo de los alimentos PROBIÓTICOS. Aprende de manera práctica cómo elaborarlos utilizando ingredientes naturales y técnicas simples y muy eficientes. Nuestro chef experto Riders Rosini te guiará paso a paso en cada proceso de fermentación, brindándote las herramientas para crear alimentos vivos que mejoran tu salud intestinal y tu bienestar general.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-4 d-flex">
    				<div class="intro color-1 d-lg-flex w-100 ftco-animate">
    					<div class="icon">
    						<span class="flaticon-cashback"></span>
    					</div>
    					<div class="text">
    						<h2>TAYTA SUSCRIPCIÓN</h2>
    						<p>Con nuestra suscripción, no solo ahorras tiempo y dinero, sino que te aseguras de tener siempre a la mano alimentos ricos en probióticos que fortalecen tu sistema inmunológico y mejoran tu digestión. En una vida ajetreada y llena de responsabilidades, déjanos ser parte de tu estilo de vida saludable y llevaremos sus alimentos justo cuando tu ya se había olvidado reponer tus kombuchas en la refri!</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-4 d-flex">
    				<div class="intro color-2 d-lg-flex w-100 ftco-animate">
    					<div class="icon">
    						<span class="flaticon-free-delivery"></span>
    					</div>
    					<div class="text">
    						<h2>DELIVERY</h2>
    						<p>Pide tus productos probióticos favoritos, como kombucha, kimchi, chucrut y ginger beer, y muchos otros más. Recíbelos directamente en la comodidad de tu hogar. Nos aseguramos de que cada entrega mantenga la frescura y calidad que nos caracteriza, permitiéndote disfrutar de los beneficios de los alimentos fermentados sin salir de casa.</p>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
	
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center pb-5">
				<div class="col-md-7 heading-section text-center ftco-animate">
					<h2>Los preferidos del mes</h2>
				</div>
			</div>
			<div class="row">
				<?php
				if ($result && $result->num_rows > 0):
					while ($row = $result->fetch_assoc()):
				?>
				<div class="col-md-3 d-flex">
					<div class="product ftco-animate">
						<div class="img d-flex align-items-center justify-content-center" style="background-image: url(<?php echo $row['ruta_imagen']; ?>); background-size: contain;">
							<div class="desc">
								<p class="meta-prod d-flex">
									<a href="cart.php?add=<?php echo $row['codigo']; ?>" class="d-flex align-items-center justify-content-center"><span class="flaticon-shopping-bag"></span></a>
									<a href="product-single.php?id=<?php echo $row['codigo']; ?>" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
								</p>
							</div>
						</div>
						<div class="text text-center">
							<span class="sale">Oferta del mes</span> 
							<span class="category"><?php echo $row['categoria']; ?></span>
							<h2><?php echo $row['titulo']; ?></h2>
							<p class="mb-0">
								<span class="price price-sale">$<?php echo number_format($row['precio'], 2); ?></span>
							</p>
						</div>
					</div>
				</div>
				<?php
					endwhile;
				else:
					echo '<p>No hay productos disponibles.</p>';
				endif;
				?>
			</div>

			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6 col-lg-4">
						<a href="product.php" class="btn btn-primary d-block text-center">
							Todos nuestros productos 
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>    

    <section class="ftco-section ftco-no-pb">
			<div class="container">
				<div class="row">
					<div class="col-md-6 img img-3 d-flex justify-content-center align-items-center" style="background-image: url(images/tayta_ponente.jpg);">
					</div>
					<div class="col-md-6 wrap-about pl-md-5 ftco-animate py-5">
	          <div class="heading-section">
	          	<span class="subheading">Desde 2014 </span>
	            <h2 class="mb-4">Talleres</h2>
	            <p>Tayta Fermentos tiene un gran propósito: Compartir bienestar.</p>
	            <p>Nuestros talleres son desarrollados para un público diverso, desde los que están iniciando al concepto de fermentación, hasta los más experimentados.</p>
				<p>Nuestro chef Riders Rosini, fundador de la marca, con más de 20 años de experiencia en los mejores restaurantes del mundo, comanda los talleres donde el conversatorio siempre va por una alimentación saludable, ayurveda, sostenibilidad y  técnicas de fermentación para la gran variedad de alimentos y bebidas fermentados. Con Riders Rosini descubrirás cómo preparar alimentos vivos como kombucha, chucrut, kimchi, masas madre, panes y mucho más, utilizando técnicas simples y naturales. Nuestros talleres no solo te enseñarán a elaborar alimentos probióticos en casa, sino que también te sumergirá en un estilo de vida más saludable y conectado con la naturaleza. ¡Únete a nosotros y empieza a fermentar tu bienestar!</p>
	            <p class="year">
	            	<strong class="number" data-number="10">0</strong>
		            <span>Años de experiencia</span>
	            </p>
	          </div>

					</div>
				</div>
			</div>
		</section>
		<br>
		<br>

    <section class="ftco-section testimony-section img" style="background-image: url(images/fondo_testimonio.jpg);">
    	<div class="overlay"></div>
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
          	<span class="subheading"></span>
            <h2 class="mb-3">Clientes felices</h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">Los productos naturales han transformado mi alimentación. Son frescos y de excelente calidad. ¡Los recomiendo totalmente a mis pacientes!</p>
                    <div class="d-flex align-items-center">
                    	<div class="pl-3">
		                    <p class="name">Diego González</p>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">La variedad de ingredientes naturales me ha inspirado en la cocina. Mis platos nunca habían sabido tan bien. ¡Una experiencia increíble!</p>
                    <div class="d-flex align-items-center">
                    	<div class="pl-3">
		                    <p class="name">Carlos Rodríguez</p>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">Desde que uso estos productos, mi energía ha aumentado. Son auténticos y nutritivos. ¡Definitivamente, seguiré comprando más!</p>
                    <div class="d-flex align-items-center">
                    	<div class="pl-3">
		                    <p class="name">Luis Herrera</p>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">Los productos son excepcionales. He notado un gran cambio en mi salud y bienestar. ¡Un gran hallazgo para mi vida diaria!</p>
                    <div class="d-flex align-items-center">
                    	<div class="pl-3">
		                    <p class="name">Javier Torres</p>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">Me encanta experimentar con los productos. Son frescos y deliciosos. ¡Perfectos para mis recetas y proyectos en la cocina!</p>
                    <div class="d-flex align-items-center">
                    	<div class="pl-3">
		                    <p class="name">Ricardo Martínez</p>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

	<a href="https://wa.me/968204147" target="_blank" class="whatsapp">
		<img src="images/whats.png" alt="WhatsApp" class="whatsapp-icon">
	   </a>
	
	
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