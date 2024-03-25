<?php
require_once "libs/Smarty.class.php";

class UserView {
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

    public function showSettings($user, $errorMsg = "", $successMsg = "") {
        $this->smarty->assign("title", "User settings");
        $this->smarty->assign("user", $user);
        $this->smarty->assign("errorMsg", $errorMsg);
        $this->smarty->assign("successMsg", $successMsg);

        $this->smarty->display("templates/settings.tpl");
    }

    public function showUsersManage($users, $roles) {
        $this->smarty->assign("title", "Users manage");
        $this->smarty->assign("users", $users);
        $this->smarty->assign("roles", $roles);

        $this->smarty->display("templates/usersManage.tpl");
    }
}
?>