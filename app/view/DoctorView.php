<?php
require_once "libs/Smarty.class.php";

class DoctorView {
    private $smarty;

    function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->assign("appointmentsUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);
    }
}
?>