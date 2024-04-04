<?php

class UserView {
    private $appointmentsUrl;
    private $baseUrl;
    private $loginUrl;

    private $userId;
    private $userUsername;
    private $userRole;
    private $userImage;

    private $dir;

    function __construct($userId, $userUsername, $userRole, $userImage) {
        $this->appointmentsUrl = APPOINTMENTS;
        $this->baseUrl = BASE_URL;
        $this->loginUrl = LOGIN;

        $this->userId = $userId;
        $this->userUsername = $userUsername;
        $this->userRole = $userRole;
        $this->userImage = $userImage;

        $this->dir = __DIR__;
    }

    public function showLogin($errorMsg = "") {
        $title = "Login";
        require_once __DIR__ . "/../../templates/login.php";
    }

    public function showSignUp($errorMsg = "") {
        $title = "Sign Up";
        require_once __DIR__ . "/../../templates/signUp.php";
    }

    public function showSettings($user, $errorMsg = "", $successMsg = "") {
        $title = "User settings";
        require_once __DIR__ . "/../../templates/settings.php";
    }

    public function showUsersManage($users, $roles) {
        $title = "Users manage";
        require_once __DIR__ . "/../../templates/usersManage.php";
    }
}
?>