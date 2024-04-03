<?php
class StatusModel {
    private $db;

    /* function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    } */

    function __construct() {
        $this->db = new PDO('mysql:host=sql10.freesqldatabase.com;dbname=sql10695904;charset=utf8', 'sql10695904', 'Mu4pt8x16n');
    }

    public function findAllStatus() {
        $query = $this->db->prepare("SELECT * FROM status");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
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