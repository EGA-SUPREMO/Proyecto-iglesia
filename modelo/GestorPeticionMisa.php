<?php

require_once 'GestorBase.php';
require_once 'PeticionMisa.php';

class GestorPeticionMisa extends GestorBase
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this ->clase_nombre = "PeticionMisa";
        $this ->tabla = "peticion_misa";
    }

    public function existeObjetoEnMisa($misa_id, $objeto_de_peticion_id)
    {
        $sql = "SELECT COUNT(*) as total 
                FROM " . $this ->tabla . " pm
                JOIN peticiones p ON pm.peticion_id = p.id
                WHERE pm.misa_id = :misa_id
                AND p.objeto_de_peticion_id = :objeto_id";

        $params = [
            ':misa_id'   => $misa_id,
            ':objeto_id' => $objeto_de_peticion_id
        ];

        $resultado = $this->hacerConsulta($sql, $params, 'assoc');

        return ($resultado['total'] > 0);
    }

    public function obtenerIntencionesDeMisaId($misa_id)
    {
        $sql = "SELECT 
                ti.nombre AS tipo_intencion,
                GROUP_CONCAT(op.nombre ORDER BY op.nombre ASC SEPARATOR ' - ') AS lista_nombres
            FROM 
                peticion_misa pm
                INNER JOIN peticiones p ON pm.peticion_id = p.id
                INNER JOIN tipo_de_intencion ti ON p.tipo_de_intencion_id = ti.id
                INNER JOIN objetos_de_peticion op ON p.objeto_de_peticion_id = op.id
            WHERE 
                pm.misa_id = :misa_id
            GROUP BY 
                ti.id, ti.nombre
            ORDER BY 
                ti.id ASC;";

        $params = [
            ':misa_id'   => $misa_id,
        ];

        $resultado = $this->hacerConsulta($sql, $params, 'assoc_all');

        return $resultado;
    }

    public function eliminarPorPeticionId($peticion_id)
    {
        $sql = "DELETE FROM {$this->tabla} WHERE peticion_id = ?";
        return $this->hacerConsulta($sql, [$peticion_id], 'execute');
    }
}
