<?php
session_start();
include('db.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['firstname'] ?? '';
    $apellidos = $_POST['lastname'] ?? '';
    $email = $_POST['emailaddress'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $celular = $_POST['phone'] ?? '';
    $tipo_compra = $_POST['tipo_compra'] ?? '';
    $direccion_cliente = $_POST['streetaddress'] ?? '';
    $codigoDistrito = $_POST['distrito'] ?? 1;
    $metodo_pago = $_POST['optradio'] ?? '';
    $total = $_POST['total'] ?? 0;
    $genero = "Masculino";

    if ($nombres && $apellidos && $email && $celular && $metodo_pago) {
        if ($tipo_compra === 'delivery' && (!$direccion_cliente || !$codigoDistrito)) {
            echo "Error: Por favor, completa todos los campos de dirección para delivery.";
            exit;
        }
        $query_cliente = "INSERT INTO cliente (nombre, apellido, email, genero, dni, celular, direccion, codigoDistrito)
                  VALUES ('$nombres', '$apellidos', '$email', '$genero', '$dni', '$celular', '$direccion_cliente', ". ($codigoDistrito ? $codigoDistrito : 'NULL') .")";

        if ($conn->query($query_cliente)) {
            $codigoCliente = $conn->insert_id;

            $query_pedido = "INSERT INTO pedido (fecha, direccion, observacion, codigoCliente, codigoDistrito, cupon_codigo, transaccionCodigo)
                             VALUES (NOW(), '$direccion_cliente', '', $codigoCliente, ". ($codigoDistrito ? $codigoDistrito : 'NULL') .", 1, '$metodo_pago')";

            if ($conn->query($query_pedido)) {
                $codigoPedido = $conn->insert_id;
                $numero_pedido = 'PED-' . sprintf('%06d', $codigoPedido);
                $query_update = "UPDATE pedido SET numero = '$numero_pedido' WHERE codigo = $codigoPedido";

                if ($conn->query($query_update)) {
                    foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
                        $query_producto = "SELECT titulo, precio FROM producto WHERE codigo = $id_producto";
                        $result_producto = $conn->query($query_producto);
                        if ($result_producto && $row = $result_producto->fetch_assoc()) {
                            $precioUnitario = $row['precio'];
                            $descripcion = $row['titulo'];

                            $query_detalle = "INSERT INTO detallepedido (cantidad, precioUnitario, descripcion, pedido_codigo, presentacion_codigo)
                                            VALUES ($cantidad, $precioUnitario, '$descripcion', $codigoPedido, 1)";
                            $conn->query($query_detalle);
                        }
                    }
                    $query_pedido_confirm = "SELECT p.numero, p.fecha, p.direccion, c.nombre, c.apellido, p.transaccionCodigo
                                            FROM pedido p
                                            JOIN cliente c ON p.codigoCliente = c.codigo
                                            WHERE p.codigo = $codigoPedido";
                    $result_pedido = $conn->query($query_pedido_confirm);
                    $pedido = $result_pedido->fetch_assoc();

                    $query_detalles = "SELECT dp.cantidad, dp.precioUnitario, dp.descripcion
                                    FROM detallepedido dp
                                    WHERE dp.pedido_codigo = $codigoPedido";
                    $result_detalles = $conn->query($query_detalles);

                    $_SESSION['carrito'] = [];

                    require 'libs/PHPMailer/src/Exception.php';
                    require 'libs/PHPMailer/src/PHPMailer.php';
                    require 'libs/PHPMailer/src/SMTP.php';

                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'mi_correo@gmail.com'; // Tu correo
                        $mail->Password = ''; // Contraseña del correo
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Configuración del correo
                        $mail->setFrom('mi_correo@gmail.com', 'Tayta Fermentos');
                        $mail->addAddress($pedido['email']); // Dirección de correo del cliente
                        $mail->addReplyTo('mi_correo@gmail.com', 'Tayta Fermentos');

                        // Contenido del correo
                        $mail->isHTML(true);
                        $mail->Subject = 'Confirmación de tu pedido en Tayta Fermentos';
                        $mail->Body    = '
                        <h2>¡Gracias por tu compra, ' . $pedido['nombre'] . '!</h2>
                        <p>Tu pedido ha sido procesado exitosamente.</p>
                        <p>Número de Pedido: <strong>' . $pedido['numero'] . '</strong></p>
                        <h4>Resumen de tu Compra</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>';

                        $total = 0;
                        while ($detalle = $result_detalles->fetch_assoc()) {
                            $subtotal = $detalle['cantidad'] * $detalle['precioUnitario'];
                            $total += $subtotal;
                            $mail->Body .= '
                            <tr>
                                <td>' . $detalle['descripcion'] . '</td>
                                <td>' . $detalle['cantidad'] . '</td>
                                <td>S/ ' . number_format($detalle['precioUnitario'], 2) . '</td>
                                <td>S/ ' . number_format($subtotal, 2) . '</td>
                            </tr>';
                        }

                        $mail->Body .= '
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align: right;">Total</th>
                                    <th>S/ ' . number_format($total, 2) . '</th>
                                </tr>
                            </tfoot>
                        </table>
                        <p>Método de Pago: <strong>' . $pedido['transaccionCodigo'] . '</strong></p>
                        <p>Dirección de Envío: <strong>' . $pedido['direccion'] . '</strong></p>';

                        // Enviar el correo
                        $mail->send();
                        echo 'El correo de confirmación ha sido enviado correctamente.';
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }

                } else {
                    echo "Error al actualizar el número de pedido: " . $conn->error;
                }
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
          	<p class="breadcrumbs mb-0"><span class="mr-2"><a href="index.php">Home <i class="fa fa-chevron-right"></i></a></span> <span><a href="product.php">Checkout <i class="fa fa-chevron-right"></i></a></span> <span>Finalizado <i class="fa fa-chevron-right"></i></span></p>
            <h2 class="mb-0 bread">Pedido Finalizado</h2>
          </div>
        </div>
      </div>
    </section>
    
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="mb-4">¡Gracias por tu compra, <?php echo $pedido['nombre'] . ' ' . $pedido['apellido']; ?>!</h2>
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
                    <p>Método de Pago: <strong>
                        <?php
                        switch ($pedido['transaccionCodigo']) {
                            case 'Transferencia':
                                echo 'Transferencia Bancaria';
                                break;
                            case 'Tarjeta':
                                echo 'Tarjeta de Crédito/Débito';
                                break;
                            case 'Yape/Plin':
                                echo 'Yape / Plin';
                                break;
                            default:
                                echo 'Método de Pago Desconocido';
                        }
                        ?>
                    </strong></p>
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