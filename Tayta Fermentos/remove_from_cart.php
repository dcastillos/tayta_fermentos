<?php
session_start(); // Iniciar la sesión para acceder al carrito

if (isset($_GET['id'])) {
    $id_producto = (int)$_GET['id']; // Obtener el ID del producto desde el parámetro GET

    // Verificar si el carrito existe en la sesión y el producto está en el carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        unset($_SESSION['carrito'][$id_producto]); // Eliminar el producto del carrito
    }
}

// Redireccionar de nuevo a la página del carrito después de eliminar
header('Location: cart.php');
exit;
?>
