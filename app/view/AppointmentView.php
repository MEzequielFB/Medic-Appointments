<?php
require_once "libs/Smarty.class.php";

class AppointmentView {
    private $smarty;

    function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->assign("appointmentsUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);
    }

    public function showAppointments($appointments) {
        $this->smarty->assign("title", "Appointments");
        $this->smarty->assign("appointments", $appointments);

        $this->smarty->display("templates/appointments.tpl");
    }

    public function showAppointmentCreation(/* $times */) {
        $this->smarty->assign("title", "Make appointment");
        /* $this->smarty->assign("times", $times); */

        $this->smarty->display("templates/makeAppointment.tpl");
    }
}
?>