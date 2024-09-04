<?php
include 'db.php'; 

if (isset($_GET['departamento_id'])) {
    $departamento_id = (int)$_GET['departamento_id'];
    $query = "SELECT codigo, nombre FROM provincia WHERE codigoDepartamento = $departamento_id";
    $result = $conn->query($query);
    $provincias = [];
    while ($row = $result->fetch_assoc()) {
        $provincias[] = $row;
    }
    echo json_encode($provincias);
}
?>
