<?php
session_start();

$errorMessage = '';
if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Acceso al Sistema</h1>
    </header>
    <main>
        <section class="contenedor">
            <?php
            if (!empty($errorMessage)) {
                echo '<p style="color: red; text-align: center; font-weight: bold;">Usuario o contraseña incorrectos.</p>';
            }
            ?>
            <form method="post" action="../controllers/LoginController.php">
                <label>Usuario:</label>
                <input type="text" name="usuario" required>
                
                <label>Contraseña:</label>
                <input type="password" name="contrasena" required>
                
                <button type="submit">Ingresar</button>
            </form>
        </section>
    </main>
</body>
</html>