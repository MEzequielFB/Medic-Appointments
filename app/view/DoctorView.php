<?php

class DoctorView {
    private $appointmentsUrl;
    private $baseUrl;
    private $loginUrl;

    private $userUsername;
    private $userRole;
    private $userImage;

    private $dir;
    
    function __construct($userUsername, $userRole, $userImage) {
        $this->appointmentsUrl = APPOINTMENTS;
        $this->baseUrl = BASE_URL;
        $this->loginUrl = LOGIN;

        $this->userUsername = $userUsername;
        $this->userRole = $userRole;
        $this->userImage = $userImage;

        $this->dir = __DIR__;
    }

    // ADMIN - SUPERADMIN
    public function showDoctorCreation($doctors, $errorMsg = "") {
        $title = "Save doctor";
        require_once __DIR__ . "/../../templates/saveDoctor.php";
    }
}
?>