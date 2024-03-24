<?php
require_once "libs/Smarty.class.php";

class UserView {
    private $smarty;

    function __construct($userUsername, $userRole) {
        $this->smarty = new Smarty();
        $this->smarty->assign("appointmentsUrl", APPOINTMENTS);
        $this->smarty->assign("baseUrl", BASE_URL);
        $this->smarty->assign("loginUrl", LOGIN);

        $this->smarty->assign("userUsername", $userUsername);
        $this->smarty->assign("userRole", $userRole);
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

    public function showSettings($user) {
        $this->smarty->assign("title", "User settings");
        $this->smarty->assign("user", $user);

        $this->smarty->display("templates/settings.tpl");
    }
}
?>