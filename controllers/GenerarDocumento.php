<?php
require_once "../models/Documento.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $plantilla = $_POST["plantilla"];
    $nombre = $_POST["nombre"];
    $fecha = $_POST["fecha"];

    $documento = new Documento();
    $archivo_generado = $documento->crearDocumento($plantilla, $nombre, $fecha);

    header("Location: ../public/documentos/$archivo_generado");
    exit;
}
?>