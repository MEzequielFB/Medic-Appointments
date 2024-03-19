<?php
require_once "libs/Smarty.class.php";

class HospitalView {
    private $smarty;

    function __construct($username) {
        $this->smarty = new Smarty();
        $this->smarty->assign("appointmentsUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);

        $this->smarty->assign("username", $username);
    }

    public function showHospitalCreation($errorMsg = "") {
        $this->smarty->assign("title", "Save hospital");
        $this->smarty->assign("errorMsg", $errorMsg);

        $this->smarty->display("templates/saveHospital.tpl");
    }
}
?>