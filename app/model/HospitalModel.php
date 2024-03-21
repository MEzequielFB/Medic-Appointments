<?php
class HospitalModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function findAllHospitals() {
        $query = $this->db->prepare("SELECT * FROM hospital");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findHospitalByName($name) {
        $query = $this->db->prepare("SELECT * FROM hospital WHERE name = ?");
        $query->execute([$name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findHospitalById($hospitalId) {
        $query = $this->db->prepare("SELECT * FROM hospital WHERE id = ?");
        $query->execute([$hospitalId]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function saveHospital($name, $address) {
        $query = $this->db->prepare("INSERT INTO hospital(name, address) VALUES(?,?)");
        $query->execute([$name, $address]);
    }

    public function updateHospital($name, $address, $hospitalId) {
        $query = $this->db->prepare("UPDATE hospital SET name = ?, address = ? WHERE id = ?");
        $query->execute([$name, $address, $hospitalId]);
    }
}
?>