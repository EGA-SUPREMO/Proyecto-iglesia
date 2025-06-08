<?php
require_once "models/Feligres.php";

class FeligresController {
    private $model;

    public function __construct() {
        $this->model = new Feligres();
    }

    public function index() {
        return $this->model->obtenerTodos();
    }

    public function show($id) {
        return $this->model->obtenerPorId($id);
    }

    public function create($nombre, $cedula) {
        return $this->model->agregar($nombre, $cedula);
    }

    public function update($id, $nombre, $cedula) {
        return $this->model->actualizar($id, $nombre, $cedula);
    }

    public function delete($id) {
        return $this->model->eliminar($id);
    }
}
?>