<?php

require_once ROOT_PATH . "vendor/autoload.php";
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

require_once "FuncionesComunes.php";

class GeneradorPdf
{
    private static $ruta_plantillas = __DIR__ . "/../public/plantillas/";
    private static $ruta_documentos = __DIR__ . "/../public/documentos/";

    public static function generarDocumento($nombre_plantilla, $datos)
    {
        $ruta_plantilla_completa = self::$ruta_plantillas . $nombre_plantilla;

        if (!file_exists($ruta_plantilla_completa)) {
            error_log("Error: La plantilla no existe en la ruta: " . $ruta_plantilla_completa);
            throw new InvalidArgumentException("Error: La plantilla no existe en la ruta: " . $ruta_plantilla_completa);
        }
        $nombre_base = pathinfo($nombre_plantilla, PATHINFO_FILENAME);
        $nombre_archivo_salida = $nombre_base . '_generado.docx';

        $ruta_salida_completa = self::$ruta_documentos . $nombre_archivo_salida;

        $plantilla = new TemplateProcessor($ruta_plantilla_completa);
        foreach ($datos as $key => $valor) {
            $plantilla->setValue($key, $valor);
        }
        $plantilla->saveAs($ruta_salida_completa);

        return $ruta_salida_completa;
    }

    public static function guardarPDF($nombre_plantilla, $datos)
    {
        $rutaAbsolutaDocumentoDocx = self::generarDocumento($nombre_plantilla, $datos);
        try {
            $rutaAbsolutaDocumentoPdf = self::convertirDocxAPdf($rutaAbsolutaDocumentoDocx);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $rutaAbsolutaDocumentoPdf = $rutaAbsolutaDocumentoDocx;
        }
        return FuncionesComunes::rutaDocumentoAUrl($rutaAbsolutaDocumentoPdf);
    }

    public function convertirDocxAPdfEnWindows($ruta_docx, $salida)
    {
        $candidatos = [
            'soffice', // Intento 1: Asumir que está en las variables de entorno (PATH)
            'C:\Program Files\LibreOffice\program\soffice.exe', // Intento 2: Ruta estándar 64-bit
            'C:\Program Files (x86)\LibreOffice\program\soffice.exe', // Intento 3: Ruta estándar 32-bit
            'C:\Program Files\OpenOffice\program\soffice.exe', // 4. Estándar OpenOffice 64-bit
            'C:\Program Files (x86)\OpenOffice\program\soffice.exe', // 5. Estándar OpenOffice 32-bit
        ];
        $errores = [];
        $convertido = false;

        foreach ($candidatos as $ejecutable) {
            $existe = false;
            if ($ejecutable === 'soffice') {
                exec('where soffice 2>NUL', $output, $return);
                $existe = ($return === 0);
            } else {
                $existe = file_exists($ejecutable);
            }

            if (!$existe) {
                continue;
            }
            $exe_path = ($ejecutable === 'soffice') ? 'soffice' : "\"$ejecutable\"";

            $docx_esc = escapeshellarg($ruta_docx);
            $out_esc = escapeshellarg($salida);

            // A partir de aquí, sabemos que el ejecutable existe
            $comando = "$exe_path --headless --convert-to pdf $docx_esc --outdir $out_esc";

            $output = [];
            $return_var = -1;

            exec($comando . " 2>&1", $output, $return_var);

            if ($return_var === 0) {
                $convertido = true;
                break;
            }

            $errores[] = "Fallo con ($ejecutable): " . implode("\n", $output);
        }

        if (!$convertido) {
            $msj_error = empty($errores)
                ? "No se encontró LibreOffice en ninguna de las rutas esperadas (PATH, Program Files, x86)."
                : implode("\n -- \n", $errores);

            throw new \Exception("Error fatal en conversión .docx a PDF en Windows: " . $msj_error);
        }
    }

    public static function convertirDocxAPdf($ruta_docx)
    {
        $ruta_pdf = str_replace('.docx', '.pdf', $ruta_docx);

        $salida = dirname($ruta_docx);

        // Detectar sistema operativo
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            /*$comando = 'soffice --headless --convert-to pdf "' . $ruta_docx . '" --outdir "' . $salida . '"';
            $comando = 'C:\Program Files\LibreOffice\program\soffice.exe --headless --convert-to pdf "' . $ruta_docx . '" --outdir "' . $salida . '"';*/
            self::convertirDocxAPdfEnWindows($ruta_docx, $salida);
        } else {
            // Linux
            // Usamos un directorio temporal como HOME para evitar problemas de permisos
            $lo_profile = sys_get_temp_dir() . '/lo_profile';
            if (!is_dir($lo_profile)) {
                mkdir($lo_profile, 0755, true);
            }
            $comando = 'export HOME="' . $lo_profile . '" && libreoffice --headless --convert-to pdf "' . $ruta_docx . '" --outdir "' . $salida . '"';
            exec($comando . " 2>&1", $output, $return_var);

            if ($return_var !== 0) {
                throw new \Exception("Error al convertir DOCX a PDF: " . implode("\n", $output));
            }
        }

        return $ruta_pdf;
    }

    public static function ImprimirDocxDirectamente($rutaAbsolutaDocumentoDocx)
    {
        $cleanPath = realpath($rutaAbsolutaDocumentoDocx);

        if ($cleanPath) {
            $cmd = "powershell -Command \"Start-Process -FilePath '$cleanPath' -Verb Print\"";

            // 3. Execute the command
            // The ignored output is to prevent the script from hanging waiting for a response
            pclose(popen("start /B " . $cmd, "r"));

            // Alternative simple version (try this if the above popen looks complex):
            // exec($cmd);

            error_log("Documento enviado a la impresora!");
        } else {
            throw new \Exception("Error: Archivo no encontrado: " . $rutaAbsolutaDocumentoDocx);
        }
    }

}
