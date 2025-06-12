<?php
require "../config.php";
require "../vendor/autoload.php";
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

class Documento {

    public function crearDocumentoDocx($plantilla, $ruta_salida, $datos) {
        $nombre_plantilla = basename($plantilla);

        $template = new TemplateProcessor($plantilla);
        foreach ($datos as $key => $value) {
            $template->setValue($key, $value);
        }
        $template->saveAs($ruta_salida);
    }

    public function crearDocumento($plantilla, $datos) {
        $extension = pathinfo($plantilla, PATHINFO_EXTENSION);
        $archivo_final = "documento_" . time() . ".$extension";
        $ruta_salida = "../public/documentos/$archivo_final";

        switch ($extension) {
            case "docx":
                $this->crearDocumentoDocx($plantilla, $ruta_salida, $datos);
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