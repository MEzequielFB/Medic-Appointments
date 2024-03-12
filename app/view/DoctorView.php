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

    // ADMIN - SUPERADMIN
    public function showDoctorCreation($specializations, $hospitals) {
        $this->smarty->assign("title", "Save doctor");
        $this->smarty->assign("specializations", $specializations);
        $this->smarty->assign("hospitals", $hospitals);

        $this->smarty->display("templates/saveDoctor.tpl");
    }
}
?>