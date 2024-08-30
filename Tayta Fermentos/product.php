<<<<<<< HEAD

<?php
include('db.php'); 

// Obtener categorías para el filtro
$query_categoria = "SELECT * FROM categoria";
$result_categoria = $conn->query($query_categoria);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tayta Fermentos</title>
=======
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Liquor Store - Free Bootstrap 4 Template by Colorlib</title>
>>>>>>> f3c1ae83fde8fba2efa039b9d9f727164d119153
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

<<<<<<< HEAD
  <?php include('header.php'); ?>    
    
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row mb-4">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <!-- Select de categorías dinámico -->
                            <select class="selectpicker" multiple title="Seleccione">
                                <?php while ($row = $result_categoria->fetch_assoc()): ?>
                                    <option><?php echo $row['nombre']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <?php
                        // Obtener productos de la base de datos
                        $query_productos = "SELECT p.codigo, p.titulo, p.precio, p.descrpcion, i.nombre as ruta, c.nombre AS categoria, p.slug 
                                            FROM producto p
                                            LEFT JOIN imagenproducto i ON p.codigo = i.producto_codigo
                                            LEFT JOIN categoria c ON p.codigoCategoria = c.codigo"; // Suponiendo que hay una imagen principal

                        $result_productos = $conn->query($query_productos);
                        while ($row = $result_productos->fetch_assoc()):
                        ?>
                        <!-- Comienzo de la tarjeta de producto -->
                        <div class="col-md-4 d-flex">
                            <div class="product ftco-animate">
                                <div class="img d-flex align-items-center justify-content-center" style="background-image: url(<?php echo $row['ruta']; ?>); background-size: contain;">
                                    <div class="desc">
                                        <p class="meta-prod d-flex">
                                            <a href="cart.php?add=<?php echo $row['codigo']; ?>" class="d-flex align-items-center justify-content-center"><span class="flaticon-shopping-bag"></span></a>
                                            <a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-heart"></span></a>
                                            <a href="product-single.php?id=<?php echo $row['codigo']; ?>" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
                                        </p>
                                    </div>
                                </div>
                                <div class="text text-center">
                                    <span class="category"><?php echo $row['categoria']; ?></span>
                                    <h2><?php echo $row['titulo']; ?></h2>
                                    <span class="price">S/ <?php echo number_format($row['precio'], 2); ?></span>
                                </div>
                            </div>
                        </div>
                        <!-- Fin de la tarjeta de producto -->
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

		<a href="https://wa.me/968204147" target="_blank" class="whatsapp">
			<img src="images/whats.png" alt="WhatsApp" class="whatsapp-icon">
		   </a>

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
=======
	<div class="wrap">
		<div class="container">
			<div class="row">
				<div class="col-md-6 d-flex align-items-center">
					<p class="mb-0 phone pl-md-2">
						<a href="#" class="mr-2"><span class="fa fa-phone mr-1"></span> NUMERO TELEFONICO</a> 
						<a href="#"><span class="fa fa-paper-plane mr-1"></span> ventas@taytafermentos.com.pe</a>
					</p>
				</div>
				<div class="col-md-6 d-flex justify-content-md-end">
					<div class="social-media mr-4">
					<p class="mb-0 d-flex">
						<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
						<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
						<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
					</p>
			</div>
			<div class="reg">
				<p class="mb-0"><a href="#" ></i>Iniciar sesión</a></p>
			</div>
				</div>
			</div>
		</div>
</div>

  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	<div class="container">
	  <a class="navbar-brand" href="index.html"><img src="images/LogoSinFondo.png" width="200" height="80"></a>
	  <div class="order-lg-last btn-group">
	  <a href="#" class="btn-cart dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  <span class="flaticon-shopping-bag"></span>
		  <div class="d-flex justify-content-center align-items-center"><small>3</small></div>
	  </a>
	  <div class="dropdown-menu dropdown-menu-right">
				<div class="dropdown-item d-flex align-items-start" href="#">
					<div class="img" style="background-image: url(images/prod-1.jpg);"></div>
					<div class="text pl-3">
						<h4>Bacardi 151</h4>
						<p class="mb-0"><a href="#" class="price">$25.99</a><span class="quantity ml-3">Quantity: 01</span></p>
					</div>
				</div>
				<div class="dropdown-item d-flex align-items-start" href="#">
					<div class="img" style="background-image: url(images/prod-2.jpg);"></div>
					<div class="text pl-3">
						<h4>Jim Beam Kentucky Straight</h4>
						<p class="mb-0"><a href="#" class="price">$30.89</a><span class="quantity ml-3">Quantity: 02</span></p>
					</div>
				</div>
				<div class="dropdown-item d-flex align-items-start" href="#">
					<div class="img" style="background-image: url(images/prod-3.jpg);"></div>
					<div class="text pl-3">
						<h4>Citadelle</h4>
						<p class="mb-0"><a href="#" class="price">$22.50</a><span class="quantity ml-3">Quantity: 01</span></p>
					</div>
				</div>
				<a class="dropdown-item text-center btn-link d-block w-100" href="cart.html">
					View All
					<span class="ion-ios-arrow-round-forward"></span>
				</a>
			  </div>
	</div>

	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="oi oi-menu"></span> Menu
	  </button>

	  <div class="collapse navbar-collapse" id="ftco-nav">
		<ul class="navbar-nav ml-auto">
		  <li class="nav-item"><a href="about.html" class="nav-link">Nosotros</a></li>
		  <li class="nav-item dropdown">
		  <li class="nav-item"><a href="product.html" class="nav-link">Productos</a></li>
		</li>
		  <li class="nav-item"><a href="blog.html" class="nav-link">Membresia</a></li>
		  <li class="nav-item"><a href="contact.html" class="nav-link">Contacto</a></li>
		  <li class="nav-item"><a href="contact.html" class="nav-link">Preguntas frecuentes</a></li>
		</ul>
	  </div>
	</div>
  </nav>
    <!-- END nav -->
    
    
    <section class="ftco-section">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<div class="row mb-4">
							<div class="col-md-12 d-flex justify-content-between align-items-center">
								<h4 class="product-select">Texto</h4>
								<select class="selectpicker" multiple>
				          <option>Bebidas</option>
				          <option>Aceites</option>
				          <option>Mantequillas</option>
				          
				        </select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 d-flex">
								<div class="product ftco-animate">
									<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/Flor\ de\ jamaica.png); background-size: contain">
										<div class="desc">
											<p class="meta-prod d-flex">
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-shopping-bag"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-heart"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
											</p>
										</div>
									</div>
									<div class="text text-center">
										
										<span class="category">Bebida</span>
										<h2>Flor de Jamaica</h2>
										<p class="mb-0"><span class="price price-sale">$0.00</span> 
									</div>
								</div>
							</div>
							<div class="col-md-4 d-flex">
								<div class="product ftco-animate">
									<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/Chucrut.png); background-size: contain">
										<div class="desc">
											<p class="meta-prod d-flex">
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-shopping-bag"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-heart"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
											</p>
										</div>
									</div>
									<div class="text text-center">
										
										<span class="category">Mantequilla</span>
										<h2>Chucrut con sal de Maras</h2>
										<span class="price">$0.00</span>
									</div>
								</div>
							</div>
							<div class="col-md-4 d-flex">
								<div class="product ftco-animate">
									<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/Kion\ y\ limon.png);">
										<div class="desc">
											<p class="meta-prod d-flex">
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-shopping-bag"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-heart"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
											</p>
										</div>
									</div>
									<div class="text text-center">
									
										<span class="category">Bebida</span>
										<h2>Kombucha</h2>
										<span class="price">$0.00</span>
									</div>
								</div>
							</div>
							<div class="col-md-4 d-flex">
								<div class="product ftco-animate">
									<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/Cafe.png);background-size: contain;">
										<div class="desc">
											<p class="meta-prod d-flex">
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-shopping-bag"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-heart"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
											</p>
										</div>
									</div>
									<div class="text text-center">
										<span class="category">Bebida</span>
										<h2>Kombucha</h2>
										<span class="price">$0.00</span>
									</div>
								</div>
							</div>

							<div class="col-md-4 d-flex">
								<div class="product ftco-animate">
									<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/Champanbucha.png);">
										<div class="desc">
											<p class="meta-prod d-flex">
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-shopping-bag"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-heart"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
											</p>
										</div>
									</div>
									<div class="text text-center">
										<span class="category">Bebida</span>
										<h2>Kombucha</h2>
										<span class="price">$0.00</span>
									</div>
								</div>
							</div>
							<div class="col-md-4 d-flex">
								<div class="product ftco-animate">
									<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/Mojito.png);">
										<div class="desc">
											<p class="meta-prod d-flex">
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-shopping-bag"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-heart"></span></a>
												<a href="#" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
											</p>
										</div>
									</div>
									<div class="text text-center">
										<span class="category">Bebida</span>
										<h2>Kombucha</h2>
										<span class="price">$0.00</span>
									</div>
								</div>
							</div>
							
						</div>
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
						<div class="sidebar-box ftco-animate">
              <div class="categories">
                <h3>Tipos de Productos</h3>
                <ul class="p-0">
                	<li><a href="#">Bebida <span class="fa fa-chevron-right"></span></a></li>
	                <li><a href="#">Aceite <span class="fa fa-chevron-right"></span></a></li>
	                <li><a href="#">Mantequilla <span class="fa fa-chevron-right"></span></a></li>
	                <li><a href="#">Product4 <span class="fa fa-chevron-right"></span></a></li>
	                <li><a href="#">Product5 <span class="fa fa-chevron-right"></span></a></li>
	                <li><a href="#">Product6 <span class="fa fa-chevron-right"></span></a></li>
                </ul>
              </div>
            </div>

            <div class="sidebar-box ftco-animate">
              <h3>Blog</h3>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque labore eos facere</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="fa fa-calendar"></span> Apr. 18, 2020</a></div>
                    <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
                  </div>
                </div>
              </div>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur.</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="fa fa-calendar"></span> Apr. 18, 2020</a></div>
                    <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
                  </div>
                </div>
              </div>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url(images/image_3.jpg);"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, .</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="fa fa-calendar"></span> Apr. 18, 2020</a></div>
                    <div><a href="#"><span class="fa fa-comment"></span> 19</a></div>
                  </div>
                </div>
              </div>
            </div>
					</div>
				</div>
			</div>
		</section>

    <footer class="ftco-footer">
      <div class="container">
        <div class="row mb-5">
          <div class="col-sm-12 col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2 logo"><a href="index.html">Tayta Fermentos</a></h2>
              <p>Far far away, behind the word mountains, far from the countries.</p>
              <ul class="ftco-footer-social list-unstyled mt-2">
                <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md">
            <div class="ftco-footer-widget mb-4 ml-md-4">
              <h2 class="ftco-heading-2">Mi cuenta</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>My Account</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Register</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Log In</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>My Order</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md">
            <div class="ftco-footer-widget mb-4 ml-md-4">
              <h2 class="ftco-heading-2">Informacion</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>About us</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Catalog</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Contact us</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Term &amp; Conditions</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Pregunntas rápidas</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>New User</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Help Center</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Report Spam</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Faq's</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Contactanos</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon fa fa-map marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon fa fa-paper-plane pr-4"></span><span class="text">info@yourdomain.com</span></a></li>
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
	  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart color-danger" aria-hidden="true"></i> by <a href="#" target="_blank">LZV</a>
	  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	          </div>
	        </div>
      	</div>
      </div>
    </footer>
>>>>>>> f3c1ae83fde8fba2efa039b9d9f727164d119153
    
  

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