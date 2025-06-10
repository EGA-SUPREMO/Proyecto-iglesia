<?php
require_once "../models/Documento.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $plantilla = $_POST["plantilla"];

    $datos = $_POST;
    $ruta_plantilla = "../public/plantillas/" . $plantilla;

    $documento = new Documento();
    $archivo_generado = $documento->crearDocumento($ruta_plantilla, $datos);

    if ($archivo_generado) {
        header("Location: ../public/documentos/$archivo_generado");
        exit;
    } else {
        echo "Error: tipo de archivo no soportado o falló la generación.";
    }
}
?>
