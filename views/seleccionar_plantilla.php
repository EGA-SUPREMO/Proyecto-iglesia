<?php
// Cargar plantillas disponibles
$plantillas = scandir("../public/plantillas");
$plantillas = array_filter($plantillas, fn($file) => !in_array($file, ['.', '..']));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Plantilla</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1>Generar Documento</h1>
    </header>
    <main>
        <section class="contenedor">
            <form method="post" action="../controllers/GenerarDocumento.php">
                <label>Selecciona la plantilla:</label>
                <select name="plantilla" required>
                    <?php foreach ($plantillas as $archivo): ?>
                        <option value="<?= htmlspecialchars($archivo) ?>"><?= htmlspecialchars($archivo) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Nombre del solicitante:</label>
                <input type="text" name="nombre" required>

                <label>Fecha de emisión:</label>
                <input type="date" name="fecha" required>

                <button type="submit">Generar Documento</button>
            </form>
        </section>
    </main>
</body>
</html>