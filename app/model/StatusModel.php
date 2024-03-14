<?php
class StatusModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function findStatusById($id) {
        $query = $this->db->prepare("SELECT * FROM status WHERE id = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findStatusByName($name) {
        $query = $this->db->prepare("SELECT * FROM status WHERE name = ?");
        $query->execute([$name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function saveStatus($name) {
        $query = $this->db->prepare("INSERT INTO status(name) VALUES(?)");
        $query->execute([$name]);
    }
}
?>