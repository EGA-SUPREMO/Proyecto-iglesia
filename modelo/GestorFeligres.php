<?php

require_once "GestorBase.php";
require_once "Feligres.php";

class GestorFeligres extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->tabla = "feligreses";
        $this ->clase_nombre = "Feligres";
    }

    public function guardar($objeto, $id = 0)
    {
        if (!$objeto->getCedula() && !$objeto->getPartidaDeNacimiento()) {
            throw new InvalidArgumentException("Error: Debe ingresar la 'Cédula' o la 'Partida de Nacimiento' para continuar. Ambos campos están vacíos.");
        }

        return parent::guardar($objeto, $id);
    }

    private function separarCedula($cedulaCompleta)
    {
        $cedulaCompleta = strtoupper($cedulaCompleta);

        if (str_starts_with($cedulaCompleta, 'V') || str_starts_with($cedulaCompleta, 'E')) {
            $nacionalidad = substr($cedulaCompleta, 0, 1);
            $numero = substr($cedulaCompleta, 1);
        } else {
            $nacionalidad = 'V';
            $numero = $cedulaCompleta;
        }
        $numeroLimpio = preg_replace('/[^0-9]/', '', $numero);

        return [
            'nacionalidad' => $nacionalidad,
            'numero' => $numeroLimpio
        ];
    }

    public function obtenerHijosPorCedulaPadre($cedulaCompleta)
    {
        $datosCedula = $this->separarCedula($cedulaCompleta);
        $sql = "
            SELECT 
                H.* FROM 
                {$this->tabla} AS P 
            JOIN 
                parentescos AS R ON P.id = R.id_padre 
            JOIN 
                {$this->tabla} AS H ON R.id_hijo = H.id 
            WHERE 
                P.cedula = ? AND P.nacionalidad = ?;
        ";
        return $this->hacerConsulta($sql, [$datosCedula['numero'], $datosCedula['nacionalidad']], 'all');
    }

    public function obtenerInfoSacramental($idFeligres)
    {
        $sql = "SELECT 
                        f.id,
                        b.id AS bautizo_id, b.fecha_bautizo,
                        com.id AS comunion_id, com.fecha_comunion,
                        conf.id AS confirmacion_id, conf.fecha_confirmacion,
                        mat.id AS matrimonio_id, mat.fecha_matrimonio
                    FROM feligreses f
                    LEFT JOIN constancia_de_fe_de_bautizo b ON f.id = b.feligres_bautizado_id
                    LEFT JOIN constancia_de_comunion com ON f.id = com.feligres_id
                    LEFT JOIN constancia_de_confirmacion conf ON f.id = conf.feligres_confirmado_id
                    LEFT JOIN constancia_de_matrimonio mat ON (f.id = mat.contrayente_1_id OR f.id = mat.contrayente_2_id)
                    WHERE f.id = ?;";

        return $this->hacerConsulta($sql, [$idFeligres], 'assoc');
    }

    public function obtenerPorCedula($cedulaCompleta)
    {
        $datosCedula = $this->separarCedula($cedulaCompleta);

        $sql = "SELECT * FROM {$this->tabla} WHERE `cedula` = ? AND `nacionalidad` = ?";
        return $this->hacerConsulta($sql, [$datosCedula['numero'], $datosCedula['nacionalidad']], 'single');
    }

    public function obtenerPorPartidaDeNacimiento($partida_de_nacimiento)
    {
        $sql = "SELECT * FROM {$this->tabla} WHERE `partida_de_nacimiento` = ?";
        return $this->hacerConsulta($sql, [$partida_de_nacimiento], 'single');
    }

    public function upsertFeligresPorArray($datosFeligres)
    {
        $id = 0;
        $feligres = $this->obtenerPorCedula($datosFeligres['cedula']);
        if (!$feligres) {
            $feligres = $this->obtenerPorPartidaDeNacimiento($datosFeligres['partida_de_nacimiento']);
        }
        if ($feligres) {
            $feligres->hydrate($datosFeligres);
            $id = $feligres->getId();
            $this->guardar($feligres, $id);
        } else {
            $feligres = new Feligres();
            $feligres->hydrate($datosFeligres);
            $id = $this->guardar($feligres);
        }

        if (!$id) {
            throw new Exception("Error al persistir el feligrés con cédula: " . $datosFeligres['cedula']);
        }

        return $id;
    }
}
