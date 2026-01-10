<?php

require_once 'Intencion.php';
require_once 'GestorPeticion.php';
require_once 'GestorPeticionMisa.php';
require_once 'GestorObjetoDePeticion.php';
require_once 'GestorIntencion.php';
require_once 'GestorMisa.php';
require_once 'ServicioBase.php';

require_once 'GeneradorPdf.php';

class ServicioIntencion extends ServicioBase
{
    private $gestorObjetoDePeticion;
    private $gestorPeticionMisa;
    private $gestorIntencion;
    private $gestorMisa;
    public static $plantilla_nombre = "intenciones.docx";

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->gestorObjetoDePeticion = new GestorObjetoDePeticion($pdo);
        $this ->gestorIntencion = new GestorIntencion($pdo);
        $this ->gestorMisa = new GestorMisa($pdo);
        $this ->gestorPeticionMisa = new GestorPeticionMisa($pdo);
    }

    public function guardar($intencion, $id = 0)
    {
        return $this->ejecutarEnTransaccion(function () use ($intencion, $id) {
            if ($id > 0) {
                // TODO NO BORRAR, INVESTIGAR PORQUE ESTA LINEA ES NECESARIA ANTES DE HACERLO
                $intencion->setId($id); // TODO CUANDO SE BORRA ESTA LINEA, FALLA LA EDICION DE INTENCIONES

                $this->gestorPeticionMisa->eliminarPorPeticionId($intencion->getId());
            }

            $objetoDePeticion = $this->gestorObjetoDePeticion->obtenerPorNombre($intencion->obtenerObjetoDePeticionNombre());
            if (!$objetoDePeticion) {
                $objetoDePeticion = new ObjetoDePeticion();
                $objetoDePeticion ->setNombre($intencion->obtenerObjetoDePeticionNombre());
                $this->gestorObjetoDePeticion->guardar($objetoDePeticion);
            }
            $intencion->setObjetoDePeticionId($objetoDePeticion->getId());

            $resultado = $this->gestorIntencion->guardar($intencion, $id);

            foreach ($intencion->obtenerMisaIds() as $misa_id) {
                $peticionMisa = new PeticionMisa();
                $peticionMisa->setPeticionId($intencion->getId());
                $peticionMisa->setMisaId($misa_id);
                if ($this->gestorPeticionMisa->existeObjetoEnMisa($misa_id, $objetoDePeticion->getId())) {
                    throw new Exception("El porque de la intención ya está agendado para esta misa.");
                }
                $this ->gestorPeticionMisa->guardar($peticionMisa);
            }

            return $resultado;
        }, "de registro o edicion de intencion");
    }

    public function generarPDF($misa_id, $fecha_misa)
    {
        $intenciones = $this->gestorPeticionMisa->obtenerIntencionesDeMisaId($misa_id);
        $intenciones = $this->convertirArrayAFormatoPDF($intenciones);

        $formateador = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Caracas',
            IntlDateFormatter::GREGORIAN,
            'EEEE'
        );
        $intenciones['fecha'] = $fecha_misa;
        $datetime = new DateTime($fecha_misa, new DateTimeZone('America/Caracas'));
        $intenciones['dia'] = $formateador->format($datetime);

        return GeneradorPdf::guardarPDF(self::$plantilla_nombre, $intenciones);
    }

    private function convertirArrayAFormatoPDF($array_original)
    {
        $array_convertido = [];
        $mapa_traduccion = [
                "Acción de Gracias" => "accion_de_gracias",
                "Salud"             => "salud",
                "Aniversarios"       => "aniversarios",
                "Difuntos"           => "difuntos",
            ];
        foreach ($array_original as $item) {
            $tipo_intencion_original = $item['tipo_intencion'];
            $lista_nombres = $item['lista_nombres'];

            $clave_normalizada = $mapa_traduccion[$tipo_intencion_original];
            $array_convertido[$clave_normalizada] = $lista_nombres;
        }

        $array_base_vacio = array_fill_keys(array_values($mapa_traduccion), '');
        $array_final = array_merge($array_base_vacio, $array_convertido);

        return $array_final;
    }
}
