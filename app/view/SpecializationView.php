<?php
require_once "libs/Smarty.class.php";

class SpecializationView {
    private $smarty;

    function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->assign("appointmentsUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);
    }

    public function showSpecializationCreation($errorMsg = "") {
        $this->smarty->assign("title", "Save specialization");
        $this->smarty->assign("errorMsg", $errorMsg);

        $this->smarty->display("templates/saveSpecialization.tpl");
    }
}
?>