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
}
?>