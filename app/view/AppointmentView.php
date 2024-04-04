<?php
require_once __DIR__ . "/../controller/AuthHelper.php";

class AppointmentView {
    private $appointmentsUrl;
    private $baseUrl;
    private $loginUrl;

    private $userUsername;
    private $userRole;
    private $userImage;

    private $dir;

    function __construct($userUsername, $userRole, $userImage) {
        $this->appointmentsUrl = APPOINTMENTS;
        $this->baseUrl = BASE_URL;
        $this->loginUrl = LOGIN;

        $this->userUsername = $userUsername;
        $this->userRole = $userRole;
        $this->userImage = $userImage;

        $this->dir = __DIR__;
    }

    public function showAppointments($appointments, $nearest) {
        $title = "Appointments";
        require_once __DIR__ . "/../../templates/appointments.php";
    }

    public function showAppointmentCreation($appointment = null, $times = null) {
        $title = "Schedule appointment";
        require_once __DIR__ . "/../../templates/saveAppointment.php";
    }

    public function showAppointmentsManage($status) {
        $title = "Appointments manager";
        require_once __DIR__ . "/../../templates/appointmentsManage.php";
    }
}
?>