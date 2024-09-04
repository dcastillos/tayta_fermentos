<?php
session_start();
include 'db.php';

if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {

        $query = "SELECT titulo, precio, i.nombre as ruta_imagen FROM producto p 
                  LEFT JOIN imagenproducto i ON p.codigo = i.producto_codigo
                  WHERE p.codigo = $id_producto";
        $result = $conn->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            echo '<div class="cart-item">';
            echo '<img src="' . $row['ruta_imagen'] . '" alt="' . $row['titulo'] . '">';
            echo '<div class="details">';
            echo '<div class="title-price">';
            echo '<p>' . $row['titulo'] . '</p>';
            echo '<p>S/ ' . number_format($row['precio'], 2) . ' x ' . $cantidad . '</p>';
            echo '</div>';
            echo '<div class="total">Total: S/ ' . number_format($row['precio'] * $cantidad, 2) . '</div>';
            echo '</div>';

            echo '<span class="remove-btn" onclick="removeFromCart(' . $id_producto . ')">&times;</span>';
            echo '</div>';
        }
    }
} else {
    echo '<p>Tu carrito está vacío.</p>';
}
?>
