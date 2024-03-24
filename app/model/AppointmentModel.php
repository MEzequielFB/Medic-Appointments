<?php
class AppointmentModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function findAppointmentById($appointmentId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, a.reason, a.user_id, d.id AS doctor_id, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, h.name AS doctor_hospital
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        WHERE a.id = ?");
        $query->execute([$appointmentId]);
        
        return $query->fetch(PDO::FETCH_OBJ);
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

    public function findAllCompletedAppointmentsByUser($userId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        WHERE a.user_id = ?
        AND (s.name = 'completed')
        ORDER BY DATE(a.date), TIME(a.date)");
        $query->execute([$userId]);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllCancelledAppointmentsByUser($userId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        WHERE a.user_id = ?
        AND (s.name = 'cancelled')
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
        $query->execute([$date]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAppointmentsTimeByDateAndDoctor($date, $doctorId) {
        $query = $this->db->prepare("SELECT TIME(a.date) AS hour, a.duration
            FROM appointment a
            JOIN status s ON a.status_id = s.id
            WHERE DATE(a.date) = ?
            AND a.doctor_id = ?
            AND (s.name = 'to be confirmed' OR s.name = 'confirmed')
            ORDER BY DATE(a.date), TIME(a.date)");
        $query->execute([$date, $doctorId]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllAppointmentsByDoctor($doctorId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital, u.username AS user_username
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        JOIN user u ON a.user_id = u.id
        WHERE a.doctor_id = ?
        ORDER BY DATE(a.date), TIME(a.date)");
        $query->execute([$doctorId]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function findAllAppointmentsByFilter($username, $date, $statusId, $doctorId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital, u.username AS user_username
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        JOIN user u ON a.user_id = u.id
        WHERE (
            u.username = ? 
            OR DATE(a.date) = ?
            OR a.status_id = ?
        )
        AND a.doctor_id = ?
        ORDER BY DATE(a.date), TIME(a.date)");
        $query->execute([$username, $date, $statusId, $doctorId]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function saveAppointment($date, $duration, $reason, $doctorId, $statusId, $userId) {
        $query = $this->db->prepare("INSERT INTO appointment(date, duration, reason, doctor_id, status_id, user_id) VALUES(?,?,?,?,?,?)");
        $query->execute([$date, $duration, $reason, $doctorId, $statusId, $userId]);
    }

    public function rescheduleAppointment($date, $duration, $reason, $statusId, $doctorId, $appointmentId) {
        $query = $this->db->prepare("UPDATE appointment SET date = ?, duration = ?, reason = ?, status_id = ?, doctor_id = ? WHERE id = ?");
        $query->execute([$date, $duration, $reason, $statusId, $doctorId, $appointmentId]);
    }

    public function cancelAppointment($statusId, $appointmentId) {
        $query = $this->db->prepare("UPDATE appointment SET status_id = ? WHERE id = ?");
        $query->execute([$statusId, $appointmentId]);
    }
}
?>