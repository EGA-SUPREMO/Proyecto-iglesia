<?php
session_start(); // Iniciar sesión para autenticación

require_once "controllers/IndexController.php"; // Controlador de la página principal

// Redirigir al login si no hay usuario autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: views/login.php");
    exit;
}

$controller = new IndexController();
$servicios = $controller->obtenerServicios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Gestión Parroquial</title>
    <link rel="stylesheet" href="public/styles.css">
</head>
<body>

    <?php include "views/header.php"; ?> <!-- Encabezado modular -->
    
    <div class="sidebar">
        <h2>Información</h2>
        <p>Imagen / Logotipo Parroquial</p>

        <h3>Requisitos</h3>
        <?php foreach ($servicios as $servicio): ?>
            <div class="module"><?= htmlspecialchars($servicio['nombre']) ?></div>
        <?php endforeach; ?>
    </div>

    <div class="main">
        <h2>Despacho Parroquial</h2>
        <?php foreach ($servicios as $servicio): ?>
            <div class="module"><?= htmlspecialchars($servicio['descripcion']) ?></div>
        <?php endforeach; ?>
    </div>

    <div class="calendar">
        <h2>Calendario</h2>
        <div class="calendar-entry">Tareas pendientes</div>
        <div class="calendar-entry">Aniversarios y Cumpleaños</div>
        <div class="calendar-entry">Registro de Difuntos</div>
        <div class="calendar-entry">Oraciones por enfermos</div>

        <h3>Facturación Diaria</h3>
        <div class="calendar-entry"><a href="views/facturas.php">Ver detalles</a></div>
    </div>

</body>
</html>