<?php
class AppointmentModel {
    private $db;

    /* function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    } */

    /* function __construct() {
        $this->db = new PDO('mysql:host=sql106.infinityfree.com;dbname=if0_36279951_appointments_db;charset=utf8', 'if0_36279951', 'yJMhgmGC7cB');
    } */

    function __construct() {
        $this->db = new PDO('mysql:host=sql10.freesqldatabase.com;dbname=sql10695904;charset=utf8', 'sql10695904', 'Mu4pt8x16n');
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
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, a.reason, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital
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
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, a.reason, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        WHERE a.user_id = ?
        AND (s.name = 'completed')
        ORDER BY DATE(a.date) DESC, TIME(a.date) DESC");
        $query->execute([$userId]);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllCancelledAppointmentsByUser($userId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, a.reason, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        WHERE a.user_id = ?
        AND (s.name = 'cancelled')
        ORDER BY DATE(a.date) DESC, TIME(a.date) DESC");
        $query->execute([$userId]);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findNearestAppointmentByUser($userId) {
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, a.reason, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital
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
        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, a.reason, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital, u.username AS user_username
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
    
    public function findAllAppointmentsByFilter($username, $date, $statusIds, $doctorId) {
        // Return a string with tokens (?) separated with commas depending on the $statusIds array length
        $in = implode(',', array_fill(0, count($statusIds), '?'));

        $query = $this->db->prepare("SELECT a.id, DATE(a.date) AS date, TIME(a.date) AS time, a.reason, d.fullname AS doctor_name, sp.name AS doctor_specialization, d.image AS doctor_image, s.name AS status, s.image AS status_image, h.name AS doctor_hospital, u.username AS user_username
        FROM appointment a
        JOIN doctor d ON a.doctor_id = d.id
        JOIN specialization sp ON d.specialization_id = sp.id
        JOIN status s ON a.status_id = s.id
        JOIN hospital h ON d.hospital_id = h.id
        JOIN user u ON a.user_id = u.id
        WHERE a.doctor_id = ?
        AND (
            u.username LIKE CONCAT(?, '%')
            AND DATE(a.date) >= ?
            AND a.status_id IN ($in)
        )
        ORDER BY DATE(a.date), TIME(a.date)");
        $query->execute(array_merge([$doctorId, $username, $date], $statusIds));

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

    public function changeAppointmentStatus($statusId, $appointmentId) {
        $query = $this->db->prepare("UPDATE appointment SET status_id = ? WHERE id = ?");
        $query->execute([$statusId, $appointmentId]);
    }

    public function completePastAppointmentsByUser($completedStatusId, $confirmedStatusId, $userId) {
        $query = $this->db->prepare("UPDATE appointment
        SET status_id = ?
        WHERE user_id = ?
        AND DATE_ADD(date, INTERVAL duration MINUTE) <= NOW()
        AND status_id = ?");
        $query->execute([$completedStatusId, $userId, $confirmedStatusId]);
    }

    public function cancelPastAppointmentsByUser($cancelledStatusId, $toBeConfirmedStatusId, $userId) {
        $query = $this->db->prepare("UPDATE appointment
        SET status_id = ?
        WHERE user_id = ?
        AND DATE_ADD(date, INTERVAL duration MINUTE) <= NOW()
        AND status_id = ?");
        $query->execute([$cancelledStatusId, $userId, $toBeConfirmedStatusId]);
    }

    public function completePastAppointments($completedStatusId, $confirmedStatusId) {
        $query = $this->db->prepare("UPDATE appointment
        SET status_id = ?
        WHERE status_id = ?
        AND DATE_ADD(date, INTERVAL duration MINUTE) <= NOW()");
        $query->execute([$completedStatusId, $confirmedStatusId]);
    }

    public function cancelPastAppointments($cancelledStatusId, $toBeConfirmedStatusId) {
        $query = $this->db->prepare("UPDATE appointment
        SET status_id = ?
        WHERE status_id = ?
        AND DATE_ADD(date, INTERVAL duration MINUTE) <= NOW()");
        $query->execute([$cancelledStatusId, $toBeConfirmedStatusId]);
    }

    public function findPastAppointmentsByUser($userId) {
        $query = $this->db->prepare("SELECT * FROM appointment
        WHERE user_id = ?
        AND DATE_ADD(date, INTERVAL duration MINUTE) <= NOW()");
        $query->execute([$userId]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
?>