<?php
session_start();
include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($nombre && $email && $password && $confirm_password) {
        if ($password !== $confirm_password) {
            header("Location: registro.php?error=contraseña_no_coincide");
            exit;
        }

        $query_verificar = "SELECT * FROM usuario WHERE email = '$email'";
        $result_verificar = $conn->query($query_verificar);

        if ($result_verificar->num_rows > 0) {
            header("Location: registro.php?error=correo_existe");
            exit;
        } else {
            $password_encriptada = password_hash($password, PASSWORD_BCRYPT);

            $query_registro = "INSERT INTO usuario (nombre, email, password) VALUES ('$nombre', '$email', '$password_encriptada')";
            if ($conn->query($query_registro)) {
                header("Location: login.php");
                exit;
            } else {
                header("Location: registro.php?error=error_db");
                exit;
            }
        }
    } else {
        header("Location: registro.php?error=campos_vacios");
        exit;
    }
}
?>
