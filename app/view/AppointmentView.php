<?php
require_once "libs/Smarty.class.php";
require_once "app/controller/AuthHelper.php";

class AppointmentView {
    private $smarty;

    function __construct($userUsername, $userRole, $userImage) {
        $this->smarty = new Smarty();
        $this->smarty->assign("appointmentsUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);

        $this->smarty->assign("userUsername", $userUsername);
        $this->smarty->assign("userRole", $userRole);
        $this->smarty->assign("userImage", $userImage);
    }

    public function showAppointments($appointments, $nearest) {
        $this->smarty->assign("title", "Appointments");
        $this->smarty->assign("appointments", $appointments);
        $this->smarty->assign("nearest", $nearest);

        $this->smarty->display("templates/appointments.tpl");
    }

    public function showAppointmentCreation($appointment = null, $times = null) {
        $this->smarty->assign("title", "Schedule appointment");
        $this->smarty->assign("appointment", $appointment);
        $this->smarty->assign("times", $times);

        $this->smarty->display("templates/saveAppointment.tpl");
    }

    public function showAppointmentsManage($status) {
        $this->smarty->assign("title", "Appointments manager");
        $this->smarty->assign("status", $status);

        $this->smarty->display("templates/appointmentsManage.tpl");
    }
}
?>