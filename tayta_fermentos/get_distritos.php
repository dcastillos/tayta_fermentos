<?php
include 'db.php';

if (isset($_GET['provincia_id'])) {
    $provincia_id = (int)$_GET['provincia_id'];
    $query = "SELECT codigo, nombre FROM distrito WHERE codigoProvincia = $provincia_id";
    $result = $conn->query($query);
    $distritos = [];
    while ($row = $result->fetch_assoc()) {
        $distritos[] = $row;
    }
    echo json_encode($distritos);
}
?>
