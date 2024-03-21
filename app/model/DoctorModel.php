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

    public function findDoctorById($id) {
        $query = $this->db->prepare("SELECT * FROM doctor WHERE id = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findDoctorByFullname($fullname) {
        $query = $this->db->prepare("SELECT * FROM doctor WHERE fullname = ?");
        $query->execute([$fullname]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findAllDoctorsByFilter($filter) {
        $query = $this->db->prepare("SELECT d.id, d.fullname, d.image, sp.name AS specialization, h.name AS hospital
            FROM doctor d
            JOIN specialization sp ON d.specialization_id = sp.id
            JOIN hospital h ON d.hospital_id = h.id
            WHERE d.fullname LIKE CONCAT(?, '%')
            OR sp.name LIKE CONCAT(?, '%')
            OR h.name LIKE CONCAT(?, '%')");
        $query->execute([$filter, $filter, $filter]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function saveDoctor($fullname, $image, $startTime, $endTime, $specialization, $hospital) {
        $query = $this->db->prepare("INSERT INTO doctor(fullname, image, start_time, end_time, specialization_id, hospital_id) VALUES(?,?,?,?,?,?)");
        $query->execute([$fullname, $image, $startTime, $endTime, $specialization, $hospital]);

        return $this->db->lastInsertId();
    }

    public function updateDoctor($fullname, $filename, $startTime, $endTime, $specialization, $hospital, $doctorId) {
        $query = $this->db->prepare("UPDATE doctor SET fullname = ?, image = ?, start_time = ?, end_time = ?, specialization_id = ?, hospital_id = ? WHERE id = ?");
        $query->execute([$fullname, $filename, $startTime, $endTime, $specialization, $hospital, $doctorId]);
    }
}
?>