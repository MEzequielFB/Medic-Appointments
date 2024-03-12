<?php
class DoctorModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function findAllDoctors() {
        $query = $this->db->prepare("SELECT d.id, d.fullname, d.image, sp.name AS specialization, h.name AS hospital
            FROM doctor d
            JOIN specialization sp ON d.specialization_id = sp.id
            JOIN hospital h ON d.hospital_id = h.id");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function saveDoctor($fullname, $image, $specialization, $hospital) {
        $query = $this->db->prepare("INSERT INTO doctor(fullname, image, specialization, hospital) VALUES(?,?,?,?)");
        $query->execute([$fullname, $image, $specialization, $hospital]);

        return $this->db->lastInsertId();
    }
}
?>