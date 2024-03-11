<?php
require_once "libs/Smarty.class.php";

class UserView {
    private $smarty;

    function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->assign("homeUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);
    }

    public function showLogin($errorMsg = "") {
        $this->smarty->assign("title", "Login");
        $this->smarty->assign("errorMsg", $errorMsg);

        $this->smarty->display("templates/login.tpl");
    }

    public function showSignUp($errorMsg = "") {
        $this->smarty->assign("title", "Sign Up");
        $this->smarty->assign("errorMsg", $errorMsg);

        $this->smarty->display("templates/signUp.tpl");
    }

    public function showUpcomingAppointments($users) {
        $this->smarty->assign("title", "Users");
        $this->smarty->assign("users", $users);

        $this->smarty->display("templates/appointments.tpl");
    }
}
?>