<?php
require_once "../controllers/FeligresController.php";
$controller = new FeligresController();
$feligreses = $controller->index();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Feligreses</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Gestión de Feligreses</h1>
    </header>
    <main>
        <section class="contenedor">
            <h2>Listado de Feligreses</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cédula</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feligreses as $f): ?>
                    <tr>
                        <td><?= htmlspecialchars($f['id']) ?></td>
                        <td><?= htmlspecialchars($f['nombre']) ?></td>
                        <td><?= htmlspecialchars($f['cedula']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Gestión Parroquial</p>
    </footer>
</body>
</html>