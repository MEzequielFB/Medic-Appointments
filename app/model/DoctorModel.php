<?php
class DoctorModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function saveDoctor($fullname, $image, $specialization, $hospital) {
        $query = $this->db->prepare("INSERT INTO doctor(fullname, image, specialization, hospital) VALUES(?,?,?,?)");
        $query->execute([$fullname, $image, $specialization, $hospital]);

        return $this->db->lastInsertId();
    }
}
?>