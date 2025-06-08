<?php
require_once "../controllers/FeligresController.php";
$controller = new FeligresController();

$nombre = "";
$cedula = "";
$id = null;

if (isset($_GET['id'])) {
    $feligres = $controller->show($_GET['id']);
    if ($feligres) {
        $nombre = $feligres['nombre'];
        $cedula = $feligres['cedula'];
        $id = $feligres['id'];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $cedula = $_POST["cedula"];

    if ($id) {
        $controller->update($id, $nombre, $cedula);
    } else {
        $controller->create($nombre, $cedula);
    }

    header("Location: feligreses.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $id ? "Editar Feligres" : "Registrar Feligres" ?></title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <header>
        <h1><?= $id ? "Editar Feligres" : "Registrar Nuevo Feligres" ?></h1>
    </header>
    <main>
        <section class="contenedor">
            <form method="post">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
                
                <label>Cédula:</label>
                <input type="text" name="cedula" value="<?= htmlspecialchars($cedula) ?>" required>
                
                <button type="submit"><?= $id ? "Actualizar" : "Registrar" ?></button>
            </form>
            <a href="feligreses.php">Volver a la lista</a>
        </section>
    </main>
</body>
</html>