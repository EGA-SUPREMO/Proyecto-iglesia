<?php
require_once "config.php";

class Servicio {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function listarServicios() {
        $stmt = $this->db->prepare("SELECT nombre, descripcion FROM servicios ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>