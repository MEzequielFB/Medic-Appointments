<?php
class AppointmentModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function findAllUpcomingAppointmentsByUser($userId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        WHERE a.user_id = ?
        AND (s.name = 'confirmed' OR s.name = 'to be confirmed')
        ORDER BY DATE(a.date), TIME(a.date)");
        $query->execute([$userId]);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findNearestAppointmentByUser($userId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        WHERE a.user_id = ?
        AND (s.name = 'confirmed')
        ORDER BY DATE(a.date), TIME(a.date)
        LIMIT 1");
        $query->execute([$userId]);
        
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findAllAppointmentsByUser($userId) {
        $query = $this->db->prepare("SELECT * FROM appointment WHERE user_id = ?");
        $query->execute([$userId]);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAppointmentsTimeByDate($date) {
        $query = $this->db->prepare("SELECT TIME(a.date) AS hour 
            FROM appointment a
            JOIN appointment a2
            WHERE DATE(a.date) = ? 
            AND TIME(a.date) != TIME(a2.date)");
            /* AND TIME(a.date) != TIME_ADD(TIME(a2.date), INTERVAL 29 MINUTE)"); */
        $query->execute([$date]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAppointmentsTimeByDateAndDoctor($date, $doctorId) {
        $query = $this->db->prepare("SELECT TIME(date) AS hour, duration
            FROM appointment
            WHERE DATE(date) = ?
            AND doctor_id = ?");
            /* AND TIME(a.date) != TIME_ADD(TIME(a2.date), INTERVAL 29 MINUTE)"); */
        $query->execute([$date, $doctorId]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /* public function findAllAppointmentsByTime($start_time, $endTime) {
        $query = $this->db->prepare("SELECT * FROM appointment WHERE TIME(date) <= ");
    } */

    public function saveAppointment($date, $duration, $reason, $doctorId, $statusId, $userId) {
        $query = $this->db->prepare("INSERT INTO appointment(date, duration, reason, doctor_id, status_id, user_id) VALUES(?,?,?,?,?,?)");
        $query->execute([$date, $duration, $reason, $doctorId, $statusId, $userId]);
    }
}
?>