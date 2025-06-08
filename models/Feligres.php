<?php
require_once "config.php";

class Feligres {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function obtenerTodos() {
        $stmt = $this->db->prepare("SELECT * FROM feligreses ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM feligreses WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregar($nombre, $cedula) {
        try {
            $stmt = $this->db->prepare("INSERT INTO feligreses (nombre, cedula) VALUES (:nombre, :cedula)");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":cedula", $cedula, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($id, $nombre, $cedula) {
        $stmt = $this->db->prepare("UPDATE feligreses SET nombre = :nombre, cedula = :cedula WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM feligreses WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>