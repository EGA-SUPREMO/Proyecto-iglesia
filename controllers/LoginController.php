<?php

session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['usuario'] ?? ''; 
    $password = $_POST['contrasena'] ?? '';

    $validUsername = 'admin';
    $validPassword = '123456789';//esto esta de adorno de todos modos

    if ($username === $validUsername && $password === $validPassword) {
        $_SESSION['loggedin'] = true; 
        $_SESSION['username'] = $username; 

        header('Location: ../views/dashboard.php');
        exit;
    } else {
        $_SESSION['error_message'] = 'Usuario o contraseña incorrectos.';
        
        header('Location: ../index.php');
        exit;
    }
} else {
    unset($_SESSION['error_message']);
    header('Location: ../index.php'); 
    exit;
}

?>