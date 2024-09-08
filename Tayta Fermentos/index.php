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
					<img src="images/WhatsApp Image 2023-05-22 at 7.47.24 AM (1).jpeg" class="d-block w-100" alt="Segunda">
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
    						<h2>Seminarios</h2>
    						<p>Nuestros seminarios están diseñados para ofrecerte un aprendizaje intensivo y especializado en un ------------. Impartidos por expertos en la materia, estos eventos te proporcionan conocimientos prácticos y actualizados, permitiéndote mejorar tus habilidades y mantenerse a la vanguardia en tu campo.
							</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-4 d-flex">
    				<div class="intro color-1 d-lg-flex w-100 ftco-animate">
    					<div class="icon">
    						<span class="flaticon-cashback"></span>
    					</div>
    					<div class="text">
    						<h2>Membresia</h2>
    						<p>Únete a nuestra Membresía de Productos Naturales y disfruta de una experiencia exclusiva diseñada para los amantes de la salud y el bienestar. Como miembro, recibirás cada mes una selección de productos naturales cuidadosamente seleccionados.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-4 d-flex">
    				<div class="intro color-2 d-lg-flex w-100 ftco-animate">
    					<div class="icon">
    						<span class="flaticon-free-delivery"></span>
    					</div>
    					<div class="text">
    						<h2>Delivery</h2>
    						<p>Con nuestro Delivery de Productos , llevamos el poder de la naturaleza directamente a tu puerta. Disfruta de una amplia variedad de productos naturales, todo sin salir de casa.</p>
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
	            <h2 class="mb-4">Seminarios</h2>

	            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam impedit omnis non necessitatibus ipsum natus unde debitis reiciendis ex, laudantium, minima eveniet dolore molestias quasi iste maxime et dignissimos! Deleniti. officiis! Et.</p>
	            <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero, ex cupiditate minus dolorum cum adipisci fugiat earum fugit, excepturi unde beatae fuga quam praesentium laboriosam qui ab labore asperiores deserunt.Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odit non assumenda dolorem cupiditate dignissimos excepturi molestiae ea sunt ullam dolor earum corporis vitae obcaecati, consequuntur, amet dicta maxime quaerat eum.</p>
	            <p class="year">
	            	<strong class="number" data-number="10">0</strong>
		            <span>Años de experiencia</span>
	            </p>
	          </div>

					</div>
				</div>
			</div>
		</section>

		

		
  
    <section class="ftco-section testimony-section img" style="background-image: url(images/fondo_testimonio.jpg);">
    	<div class="overlay"></div>
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
          	<span class="subheading">Testimonios</span>
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
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <div class="d-flex align-items-center">
                    	<div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
                    	<div class="pl-3">
		                    <p class="name">Roger Scott</p>
		                    <span class="position">Marketing Manager</span>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <div class="d-flex align-items-center">
                    	<div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
                    	<div class="pl-3">
		                    <p class="name">Roger Scott</p>
		                    <span class="position">Marketing Manager</span>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <div class="d-flex align-items-center">
                    	<div class="user-img" style="background-image: url(images/person_3.jpg)"></div>
                    	<div class="pl-3">
		                    <p class="name">Roger Scott</p>
		                    <span class="position">Marketing Manager</span>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <div class="d-flex align-items-center">
                    	<div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
                    	<div class="pl-3">
		                    <p class="name">Roger Scott</p>
		                    <span class="position">Marketing Manager</span>
		                  </div>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap py-4">
                	<div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
                  <div class="text">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <div class="d-flex align-items-center">
                    	<div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
                    	<div class="pl-3">
		                    <p class="name">Roger Scott</p>
		                    <span class="position">Marketing Manager</span>
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