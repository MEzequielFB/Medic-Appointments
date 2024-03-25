<?php
require_once "libs/Smarty.class.php";

class SpecializationView {
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

    public function showSpecializationCreation($specializations, $errorMsg = "") {
        $this->smarty->assign("title", "Save specialization");
        $this->smarty->assign("errorMsg", $errorMsg);
        $this->smarty->assign("specializations", $specializations);

        $this->smarty->display("templates/saveSpecialization.tpl");
    }
}
?>