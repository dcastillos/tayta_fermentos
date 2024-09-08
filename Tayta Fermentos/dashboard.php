<?php
session_start();
include('db.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Consultas para los gráficos y el historial de pedidos
$query_pedidos_por_mes = "SELECT MONTH(fecha) as mes, COUNT(*) as total FROM pedido WHERE codigoCliente = $usuario_id GROUP BY mes";
$result_pedidos_por_mes = $conn->query($query_pedidos_por_mes);

// Datos para el gráfico circular
$query_estado_pedidos = "SELECT observacion, COUNT(*) as total FROM pedido WHERE codigoCliente = $usuario_id GROUP BY observacion";
$result_estado_pedidos = $conn->query($query_estado_pedidos);

// Historial de pedidos
$query_historial_pedidos = "
    SELECT 
        p.codigo AS pedido_codigo,
        p.numero,
        p.fecha,
        p.observacion,
        SUM(dp.cantidad * dp.precioUnitario) AS total
    FROM 
        pedido p
    JOIN 
        detallepedido dp ON p.codigo = dp.pedido_codigo
    WHERE codigoCliente = $usuario_id 
    GROUP BY 
        p.codigo, p.numero, p.fecha, p.observacion;
";
$result_historial_pedidos = $conn->query($query_historial_pedidos);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Mi Cuenta - Tayta Fermentos</title>
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

    
    <style>
        .sidebar {
            background-color: #CF5B65; 
            color: #fff; 
            min-height: 100%;
        }
        .sidebar .nav-link {
            color: #fff;
            margin-bottom: 10px;
        }
        .sidebar .nav-link.active {
            background-color: #495057;
            border-radius: 5px;
        }
        .content {
            padding-top: 20px;
        }

    </style>
</head>
<body>

<?php include('header.php'); ?>

<section class="ftco-section bg-light" style="margin-top: 20px;">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar p-4">
                    <h4 class="text-center py-3">Mi Cuenta</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#resumen" class="nav-link active" data-toggle="tab">Resumen</a>
                        </li>
                        <li class="nav-item">
                            <a href="#historial" class="nav-link" data-toggle="tab">Historial de Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a href="#perfil" class="nav-link" data-toggle="tab">Mi Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">Salir</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="content p-4">
                    <div class="tab-content">
                        <!-- Sección Resumen -->
                        <div class="tab-pane fade show active" id="resumen">
                            <h2>Resumen de Pedidos</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="graficoPedidosMes"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="graficoEstadoPedidos"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Historial de Pedidos -->
                        <div class="tab-pane fade" id="historial">
                            <h2>Historial de Pedidos</h2>
                            <table class="table">
                                <thead style="background-color:#495057">
                                    <tr>
                                        <th>Número de Pedido</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($pedido = $result_historial_pedidos->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $pedido['numero']; ?></td>
                                        <td><?php echo $pedido['fecha']; ?></td>
                                        <td><?php echo $pedido['observacion']; ?></td>
                                        <td>S/ <?php echo number_format($pedido['total'], 2); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Sección Mi Perfil -->
                        <div class="tab-pane fade" id="perfil">
                            <h2>Mi Perfil</h2>
                            <form action="actualizar_perfil.php" method="POST">
                                <div class="form-group">
                                    <label for="nombre">Nombre Completo:</label>
                                    <input type="text" class="form-control" name="nombre" value="<?php echo $_SESSION['usuario_nombre']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo Electrónico:</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['usuario_email']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Actualizar Información</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>

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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    var ctx1 = document.getElementById('graficoPedidosMes').getContext('2d');
    var graficoPedidosMes = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: [<?php while ($row = $result_pedidos_por_mes->fetch_assoc()) { echo '"' . $row['mes'] . '",'; } ?>],
            datasets: [{
                label: 'Pedidos por Mes',
                data: [<?php mysqli_data_seek($result_pedidos_por_mes, 0); while ($row = $result_pedidos_por_mes->fetch_assoc()) { echo $row['total'] . ','; } ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.5)'
            }]
        }
    });

 
    var ctx2 = document.getElementById('graficoEstadoPedidos').getContext('2d');
    var graficoEstadoPedidos = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: [<?php while ($row = $result_estado_pedidos->fetch_assoc()) { echo '"' . $row['estado'] . '",'; } ?>],
            datasets: [{
                data: [<?php mysqli_data_seek($result_estado_pedidos, 0); while ($row = $result_estado_pedidos->fetch_assoc()) { echo $row['total'] . ','; } ?>],
                backgroundColor: ['#007bff', '#28a745', '#ffc107']
            }]
        }
    });
</script>

</body>
</html>
