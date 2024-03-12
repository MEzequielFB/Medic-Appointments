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
}
?>