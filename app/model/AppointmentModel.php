<?php
class AppointmentModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function findAllUpcomingAppointmentsByUser($userId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        WHERE a.user_id = ?");
        $query->execute([$userId]);
        
        $query->fetchAll(PDO::FETCH_OBJ);
    }

    /* public function findAllAppointmentsByTime($start_time, $endTime) {
        $query = $this->db->prepare("SELECT * FROM appointment WHERE TIME(date) <= ");
    } */

    public function saveAppointment($date, $doctorId, $statusId, $userId) {
        $query = $this->db->prepare("INSERT INTO appointment(date, doctor_id, status_id, user_id) VALUES(?,?,?,?)");
        $query->execute([$date, $doctorId, $statusId, $userId]);
    }
}
?>