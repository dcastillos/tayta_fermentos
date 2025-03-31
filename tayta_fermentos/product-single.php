<?php
include('db.php'); // Conexión a la base de datos

// Verificar si el ID del producto está presente en la URL
if (isset($_GET['id'])) {
    $id_producto = (int)$_GET['id'];

    // Consulta para obtener los detalles del producto desde la base de datos
    $query_producto = "SELECT p.titulo, p.precio, p.descrpcion, p.slug, i.nombre as ruta_imagen
                       FROM producto p
                       LEFT JOIN imagenproducto i ON p.codigo = i.producto_codigo
                       WHERE p.codigo = $id_producto";
    
    $result_producto = $conn->query($query_producto);

    // Verificar si el producto existe en la base de datos
    if ($result_producto && $result_producto->num_rows > 0) {
        $producto = $result_producto->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID de producto no especificado.";
    exit;
}
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
    
    <section class="hero-wrap hero-wrap-2" style="background-color: black; color: white;" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center single_product">
          <div class="col-md-9 ftco-animate mb-5 text-center">
          	<p class="breadcrumbs mb-0"><span class="mr-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span><a href="product.html">Products <i class="fa fa-chevron-right"></i></a></span> <span>Products Single <i class="fa fa-chevron-right"></i></span></p>
            <h2 class="mb-0 bread">Products Single</h2>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
		<div class="container">
			<div class="row">
				<!-- Mostrar la imagen del producto -->
				<div class="col-lg-6 mb-5 ftco-animate">
					<a href="<?php echo $producto['ruta_imagen']; ?>" class="image-popup prod-img-bg">
						<img src="<?php echo $producto['ruta_imagen']; ?>" class="img-fluid" alt="<?php echo $producto['titulo']; ?>">
					</a>
				</div>

				<!-- Mostrar detalles del producto -->
				<div class="col-lg-6 product-details pl-md-5 ftco-animate">
					<h3><?php echo $producto['titulo']; ?></h3>
					<div class="rating d-flex">
						<p class="text-left mr-4">
							<a href="#" class="mr-2">5.0</a>
							<a href="#"><span class="fa fa-star"></span></a>
							<a href="#"><span class="fa fa-star"></span></a>
							<a href="#"><span class="fa fa-star"></span></a>
							<a href="#"><span class="fa fa-star"></span></a>
							<a href="#"><span class="fa fa-star"></span></a>
						</p>
						<p class="text-left mr-4">
							<a href="#" class="mr-2" style="color: #000;">100 <span style="color: #bbb;">Rating</span></a>
						</p>
						<p class="text-left">
							<a href="#" class="mr-2" style="color: #000;">500 <span style="color: #bbb;">Sold</span></a>
						</p>
					</div>
					<p class="price"><span>S/ <?php echo number_format($producto['precio'], 2); ?></span></p>
					<p style="font-family: 'RobotoLight', sans-serif"><?php echo $producto['descrpcion']; ?></p>
					<div class="row mt-4">
						<div class="input-group col-md-6 d-flex mb-3">
							<span class="input-group-btn mr-2">
								<button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
									<i class="fa fa-minus"></i>
								</button>
							</span>
							<input type="text" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="1" max="<?php echo "10" ?>">
							<span class="input-group-btn ml-2">
								<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
									<i class="fa fa-plus"></i>
								</button>
							</span>
						</div>
						<div class="w-100"></div>
						<div class="col-md-12">
							<p style="color: #000;"><?php echo "10"; ?> productos disponibles</p>
						</div>
					</div>
					<div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
						<a href="cart.php?add=<?php echo $id_producto; ?>" class="btn btn-primary py-3 px-4">Añadir al Carrito</a>
						<a href="cart.php?buy_now=<?php echo $id_producto; ?>" class="btn btn-primary py-3 px-4">Comprar Ahora</a>
					</div>
				</div>
			</div>

			<!-- Sección de pestañas para descripción adicional, fabricante y reseñas -->
			<div class="row mt-5">
				<div class="col-md-12 nav-link-wrap">
					<div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link ftco-animate active mr-lg-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Descripción</a>
						<a class="nav-link ftco-animate mr-lg-1" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Fabricante</a>
						<a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Reseñas</a>
					</div>
				</div>
				<div class="col-md-12 tab-wrap">
					<div class="tab-content bg-light" id="v-pills-tabContent">
						<!-- Tab de descripción -->
						<div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
							<div class="p-4">
								<h3 class="mb-4"><?php echo $producto['titulo']; ?></h3>
								<p style="font-family: 'RobotoLight', sans-serif"><?php echo $producto['descrpcion']; ?></p>
							</div>
						</div>
						<!-- Otros Tabs (Fabricante, Reseñas) -->
						<!-- Puedes añadir más detalles si están disponibles en la base de datos -->
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

  <script>
		$(document).ready(function(){

		var quantitiy=0;
		   $('.quantity-right-plus').click(function(e){
		        
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		            
		            $('#quantity').val(quantity + 1);

		          
		            // Increment
		        
		    });

		     $('.quantity-left-minus').click(function(e){
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		      
		            // Increment
		            if(quantity>0){
		            $('#quantity').val(quantity - 1);
		            }
		    });
		    
		});
	</script>
    
  </body>
</html>