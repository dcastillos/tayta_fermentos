<?php
session_start();
include('db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if ($email && $password) {
        $query = "SELECT * FROM usuario WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result && $user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['usuario_id'] = $user['codigo'];
                $_SESSION['usuario_nombre'] = $user['nombre'];

                if ($remember) {
                    setcookie('email', $email, time() + (86400 * 30), "/"); 
                    setcookie('password', $row['password'], time() + (86400 * 30), "/"); 
                }

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Correo no registrado.";
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }

    header("Location: login.php?error=" . urlencode($error));
    exit;
} else {
    echo "Método no permitido.";
    exit;
}
?>
