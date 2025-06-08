<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido al Panel de Administración</h1>
    </header>
    <main>
        <section class="contenedor">
            <h2>Opciones Disponibles</h2>
            <nav>
                <ul>
                    <li><a href="seleccionar_plantilla.php">Gestionar Plantillas</a></li>
                    <li><a href="feligreses.php">Gestionar Feligreses</a></li>
                    <li><a href="servicios.php">Gestionar Servicios</a></li>
                    <li><a href="pagos.php">Registro de Pagos</a></li>
                    <li><a href="../controllers/logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </section>
    </main>
</body>
</html>