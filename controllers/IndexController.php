<?php
require_once "models/Servicio.php";

class IndexController {
    private $model;

    public function __construct() {
        $this->model = new Servicio();
    }

    public function obtenerServicios() {
        return $this->model->listarServicios();
    }
}
?>