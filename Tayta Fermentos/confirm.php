<?php
session_start();
include('db.php'); // Conexión a la base de datos

// Verificar si el formulario fue enviado correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombres = $_POST['firstname'] ?? '';
    $apellidos = $_POST['lastname'] ?? '';
    $email = $_POST['emailaddress'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $celular = $_POST['phone'] ?? '';
    $direccion_cliente = $_POST['streetaddress'] ?? '';
    $codigoDistrito = $_POST['codigoDistrito'] ?? '';
    $metodo_pago = $_POST['optradio'] ?? '';
    $total = $_POST['total'] ?? 0;

    // Validar campos requeridos
    if ($nombres && $apellidos && $email && $celular && $direccion_cliente && $codigoDistrito && $metodo_pago) {
        // Guardar el cliente en la tabla cliente
        $query_cliente = "INSERT INTO cliente (nombre, apellido, email, genero, dni, celular, direccion, codigoDistrito)
                          VALUES ('$nombres', '$apellidos', '$email', 'Masculino' '$dni', '$celular', '$direccion_cliente', $codigoDistrito)";
        
        if ($conn->query($query_cliente)) {
            // Obtener el ID del cliente recién insertado
            $codigoCliente = $conn->insert_id;

            // Generar un número de pedido único
            $numero_pedido = 'PED-' . time();

            // Guardar el pedido en la tabla pedido
            $query_pedido = "INSERT INTO pedido (numero, fecha, direccion, codigoCliente, codigoDistrito, transaccionCodigo)
                             VALUES ('$numero_pedido', NOW(), '$direccion_cliente', $codigoCliente, $codigoDistrito, '$metodo_pago')";

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

                // Obtener los detalles para mostrar en la confirmación
                $query_pedido_confirm = "SELECT p.numero, p.fecha, p.direccion, c.nombre, c.apellido, t.metodo_pago
                                         FROM pedido p
                                         JOIN cliente c ON p.codigoCliente = c.codigo
                                         LEFT JOIN transaccion t ON p.transaccionCodigo = t.codigo
                                         WHERE p.codigo = $codigoPedido";
                $result_pedido = $conn->query($query_pedido_confirm);
                $pedido = $result_pedido->fetch_assoc();

                // Obtener los detalles de los productos del pedido
                $query_detalles = "SELECT dp.cantidad, dp.precioUnitario, dp.descripcion
                                   FROM detallepedido dp
                                   WHERE dp.pedido_codigo = $codigoPedido";
                $result_detalles = $conn->query($query_detalles);

                // Limpiar el carrito después de procesar la orden
                $_SESSION['carrito'] = [];
            } else {
                echo "Hubo un error al procesar tu pedido. Por favor, intenta de nuevo.";
                exit;
            }
        } else {
            echo "Hubo un error al guardar los datos del cliente. Por favor, intenta de nuevo.";
            exit;
        }
    } else {
        echo "Error: Por favor, completa todos los campos requeridos.";
        exit;
    }
} else {
    echo "Error: No se recibieron datos del formulario.";
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
  </head>
  <body>

  <?php include('header.php'); ?>   
    <!-- END nav -->
	<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
          <div class="col-md-9 ftco-animate mb-5 text-center">
          	<p class="breadcrumbs mb-0"><span class="mr-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span><a href="product.html">Checkout <i class="fa fa-chevron-right"></i></a></span> <span>Products Single <i class="fa fa-chevron-right"></i></span></p>
            <h2 class="mb-0 bread">Pedido Finalizado</h2>
          </div>
        </div>
      </div>
    </section>
    

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="mb-4">¡Gracias por tu compra, <?php echo $pedido['nombre']; ?>!</h2>
                    <p>Tu pedido ha sido procesado exitosamente.</p>
                    <p class="lead">Número de Pedido: <strong><?php echo $pedido['numero']; ?></strong></p>
                    <hr class="mb-4">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h4 class="mb-4">Resumen de tu Compra</h4>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            while ($detalle = $result_detalles->fetch_assoc()):
                                $subtotal = $detalle['cantidad'] * $detalle['precioUnitario'];
                                $total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo $detalle['descripcion']; ?></td>
                                <td><?php echo $detalle['cantidad']; ?></td>
                                <td>S/ <?php echo number_format($detalle['precioUnitario'], 2); ?></td>
                                <td>S/ <?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th>S/ <?php echo number_format($total, 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>

                    <h4 class="mt-5">Detalles del Pago</h4>
                    <p>Método de Pago: <strong><?php echo $pedido['metodo_pago']; ?></strong></p>
                    <p>Dirección de Envío: <strong><?php echo $pedido['direccion']; ?></strong></p>

                    <div class="mt-5">
                        <a href="index.php" class="btn btn-primary">Volver a la Tienda</a>
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