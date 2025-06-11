<?php
// Cargar plantillas disponibles
$plantillas = scandir("../public/plantillas");
$plantillas = array_filter($plantillas, fn($file) => !in_array($file, ['.', '..']));

$plantilla_seleccionada = $_POST['plantilla'] ?? '';

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
            <h2>Paso 1: Elige la plantilla</h2>
            <form method="post" action="" autocomplete="off">
                <label for="plantilla">Selecciona la plantilla:</label>
                <select name="plantilla" id="plantilla" required>
                    <option value="">-- Elige una opción --</option>
                    <?php foreach ($plantillas as $archivo): ?>
                        <?php
                            // Marcamos como "selected" la opción que ya fue elegida
                            $selected = ($archivo === $plantilla_seleccionada) ? 'selected' : '';
                        ?>
                        <option value="<?= htmlspecialchars($archivo) ?>" <?= $selected ?>>
                            <?= htmlspecialchars(pathinfo($archivo, PATHINFO_FILENAME)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Cargar Formulario</button>
            </form>
        </section>
        <?php
        if ($plantilla_seleccionada != ''):
        ?>
            <section class="contenedor">
                <h2>Paso 2: Rellena los datos</h2>
                <form method="post" action="../controllers/GenerarDocumento.php" autocomplete="off">
                    <input type="hidden" name="plantilla" value="<?= htmlspecialchars($plantilla_seleccionada) ?>">
                    <?php
                    $template_file_name = str_replace('.docx', '', $plantilla_seleccionada);
                    $include_path = $template_file_name . '.php';

                    if (file_exists($include_path)) {
                        include $include_path;
                    } else {
                        echo '<p>Error: plantilla no existe.</p>';
                    }
                    ?>
                    <br>
                    <button type="submit">Generar Documento Final</button>
                </form>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>