<?php
require "../config.php";
require "../vendor/autoload.php";
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

class Documento {

    public function crearDocumentoDocx($plantilla, $ruta_salida, $nombre, $fecha) {
        $nombre_plantilla = basename($plantilla);

        switch ($nombre_plantilla) {
            case "test.docx":
                $template = new TemplateProcessor($plantilla);
                $template->setValue('nombre', $nombre);
                $template->setValue('fecha', $fecha);
                $template->saveAs($ruta_salida);
                break;
            default:
                return;
        }
    }

    public function crearDocumento($plantilla, $nombre, $fecha) {
        $extension = pathinfo($plantilla, PATHINFO_EXTENSION);
        $archivo_final = "documento_" . time() . ".$extension";
        $ruta_salida = "../public/documentos/$archivo_final";

        switch ($extension) {
            case "docx":
                $this->crearDocumentoDocx($plantilla, $ruta_salida, $nombre, $fecha);
                break;

            case "xlsx":
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'Solicitante');
                $sheet->setCellValue('B1', 'Fecha');
                $sheet->setCellValue('A2', $nombre);
                $sheet->setCellValue('B2', $fecha);
                $writer = new Xlsx($spreadsheet);
                $writer->save($ruta_salida);
                break;

            case "pdf":
                $pdf = new TCPDF();
                $pdf->AddPage();
                $pdf->SetFont('Helvetica', '', 12);
                $pdf->Write(0, "Documento generado para: $nombre");
                $pdf->Ln();
                $pdf->Write(0, "Fecha: $fecha");
                $pdf->Output($ruta_salida, 'F');
                break;

            default:
                return false;
        }

        return $archivo_final;
    }
}
?>