<?php

require_once 'App.php';
require_once 'EntidadFactory.php';
require_once 'FuncionesComunes.php';

class GestionPeticionMisa
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = App::obtenerConexion();
    }

    public function manejarSolicitudDeBusqueda($postData)
    {
        $datos_json = $postData['json'] ?? '{}';
        $datos = json_decode($datos_json, true);

        if (isset($datos['metodo']) && $datos['metodo'] === 'consultarOCrearMisas') {
            $datos['fecha_fin'] = FuncionesComunes::limpiarString($datos['fecha_fin']);
            $datos['fecha_inicio'] = FuncionesComunes::limpiarString($datos['fecha_inicio']);
            $datos['objeto_de_peticion_nombre'] = FuncionesComunes::limpiarString($datos['objeto_de_peticion_nombre'] ?? '');

            return $this->consultarOCrearMisas($datos);
        } elseif (isset($datos['metodo']) && $datos['metodo'] === 'obtenerIntencionesDeMisaId') {
            $gestorPeticionMisa = EntidadFactory::crearGestor($this->pdo, 'peticion_misa');

            return $gestorPeticionMisa->obtenerIntencionesDeMisaId($datos['misa_id'], false);
        }
    }

    private function consultarOCrearMisas($datos)
    {
        $gestorMisa = EntidadFactory::crearGestor($this->pdo, 'Misa');
        $servicioMisa = EntidadFactory::crearServicio($this->pdo, 'Misa');

        $fechaInicioReq = new DateTime($datos['fecha_inicio']);
        $fechaFinReq = new DateTime($datos['fecha_fin']);

        $fechaInicioReq->setTime(0, 0, 0);
        $fechaFinReq->setTime(23, 59, 59);

        $servicioMisa->generarMisasEnRango($fechaInicioReq, $fechaFinReq);

        // === PARTE B: CONSULTA FINAL ===

        $formatoDiaSemana = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Caracas' // Ajusta a tu zona horaria para precisión (o déjala nula si no importa la zona)
        );
        $formatoDiaSemana->setPattern('EEEE'); // Ejemplo: "jueves"

        // El formato 'h:mm a' es para 12 horas con AM/PM (ej. 07:00 PM)
        $formatoHora = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::NONE,
            IntlDateFormatter::SHORT
        );
        $formatoHora->setPattern('h:mm a'); // Ejemplo: "7:00 p. m." (Si prefieres "7:00 PM", usa 'A' mayúscula: 'h:mm A')

        $misas_sin_intencion = $gestorMisa->obtenerMisasSinIntencionRegistradaPorRangoFechas($datos['fecha_inicio'], $datos['fecha_fin'], $datos['objeto_de_peticion_nombre']);
        $misas_con_peticion = [];

        if (!empty($datos['peticion_id'])) {
            $misas_con_peticion = $gestorMisa->obtenerMisasConIntencionRegistradaPorPeticionIdYRangoFechas($datos['fecha_inicio'], $datos['fecha_fin'], $datos['peticion_id']);
        }
        $misas = array_merge($misas_sin_intencion, $misas_con_peticion);

        $respuesta = [];
        foreach ($misas as $misa) {
            $misa_arr = $misa->toArrayParaBD();
            $timestamp = strtotime($misa_arr['fecha_hora']);
            $misa_arr['hora_formato'] = $formatoHora->format($timestamp);
            $misa_arr['dia_semana'] = ucfirst($formatoDiaSemana->format($timestamp));
            $respuesta[] = $misa_arr;
        }

        if (empty($respuesta)) {
            $misasEncontradas = $gestorMisa->obtenerMisasPorRangoFechas($datos['fecha_inicio'], $datos['fecha_fin']);
            if (empty($misasEncontradas)) {
                $respuesta = ['mensaje' => "No se encontraron misas en el rango de fechas especificado. Verifique que todos los campos del formulario sean correctos"];
            } else {
                $respuesta = ['mensaje' => "Todas las misas para este rango de fechas ya tienen esta intención registrada."];
            }
        }

        return $respuesta;
    }
}


App::iniciar();

$misa = new GestionPeticionMisa();
$respuesta = $misa->manejarSolicitudDeBusqueda($_POST);
header('Content-Type: application/json');
echo json_encode($respuesta);
exit();
