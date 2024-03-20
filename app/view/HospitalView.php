<?php
require_once "libs/Smarty.class.php";

class HospitalView {
    private $smarty;

    function __construct($userUsername, $userRole) {
        $this->smarty = new Smarty();
        $this->smarty->assign("appointmentsUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);

        $this->smarty->assign("userUsername", $userUsername);
        $this->smarty->assign("userRole", $userRole);
    }

    public function showHospitalCreation($hospitals, $errorMsg = "") {
        $this->smarty->assign("title", "Save hospital");
        $this->smarty->assign("errorMsg", $errorMsg);
        $this->smarty->assign("hospitals", $hospitals);

        $this->smarty->display("templates/saveHospital.tpl");
    }
}
?>