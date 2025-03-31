<?php
include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigoDistrito'])) {
    $codigoDistrito = $_POST['codigoDistrito'];
    $query = "SELECT costo FROM costo_delivery WHERE codigoDistrito = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $codigoDistrito);
    $stmt->execute();
    $stmt->bind_result($costo);
    $stmt->fetch();

    if ($costo === null) {
        $costo = 0.00; 
    }

    echo $costo; 
    $stmt->close();
} else {
    echo 0.00; 
}
?>
