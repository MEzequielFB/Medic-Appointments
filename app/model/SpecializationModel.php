<?php
class SpecializationModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function findAllSpecializations() {
        $query = $this->db->prepare("SELECT * FROM specialization");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findSpecializationByName($name) {
        $query = $this->db->prepare("SELECT * FROM specialization WHERE name = ?");
        $query->execute([$name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findSpecializationById($specializationId) {
        $query = $this->db->prepare("SELECT * FROM specialization WHERE id = ?");
        $query->execute([$specializationId]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function saveSpecialization($name) {
        $query = $this->db->prepare("INSERT INTO specialization(name) VALUES(?)");
        $query->execute([$name]);
    }

    public function updateSpecialization($name, $specializationId) {
        $query = $this->db->prepare("UPDATE specialization SET name = ? WHERE id = ?");
        $query->execute([$name, $specializationId]);
    }
}
?>