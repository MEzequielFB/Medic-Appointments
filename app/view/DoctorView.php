<?php
require_once "libs/Smarty.class.php";

class DoctorView {
    private $smarty;

    function __construct($userUsername, $userRole) {
        $this->smarty = new Smarty();
        $this->smarty->assign("appointmentsUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);

        $this->smarty->assign("userUsername", $userUsername);
        $this->smarty->assign("userRole", $userRole);
    }

    // ADMIN - SUPERADMIN
    public function showDoctorCreation($doctors, $errorMsg = "") {
        $this->smarty->assign("title", "Save doctor");
        $this->smarty->assign("errorMsg", $errorMsg);
        $this->smarty->assign("doctors", $doctors);

        $this->smarty->display("templates/saveDoctor.tpl");
    }
}
?>