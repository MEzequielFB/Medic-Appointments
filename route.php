<?php
require_once "Router.php";
require_once "app/controller/UserController.php";
require_once "app/controller/AppointmentController.php";
require_once "app/controller/DoctorController.php";
require_once "app/controller/SpecializationController.php";
require_once "app/controller/HospitalController.php";

if ($_SERVER['SERVER_NAME'] === "localhost") {
    define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']));
} else {
    /* define('BASE_URL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' . '://' . $_SERVER['HTTP_HOST']); */
    define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST']);
}

define('LOGIN', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . "/login");
define('APPOINTMENTS', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . "/appointments");

$router = new Router();

// Authentication
$router->addRoute("login", "GET", "UserController", "showLogin");
$router->addRoute("logout", "GET", "UserController", "logoutUser");
$router->addRoute("authentication", "POST", "UserController", "authenticateUser");
$router->addRoute("signUp", "GET", "UserController", "showSignUp");

// User
$router->addRoute("settings", "GET", "UserController", "showSettings");
$router->addRoute("users/manage", "GET", "UserController", "showUsersManage");
$router->addRoute("user", "POST", "UserController", "saveUser");
$router->addRoute("user/updateProfileImage", "POST", "UserController", "updateProfileImage");

// Appointment
$router->addRoute("appointments", "GET", "AppointmentController", "showAllUpcomingAppointmentsByUser");
$router->addRoute("appointment/save", "GET", "AppointmentController", "showAppointmentCreation");
$router->addRoute("appointment/:ID/reschedule", "GET", "AppointmentController", "showAppointmentReschedule");
$router->addRoute("appointment/:ID/cancel", "GET", "AppointmentController", "cancelAppointment");
$router->addRoute("appointment/:ID/confirm", "GET", "AppointmentController", "confirmAppointment");
$router->addRoute("appointments/manage", "GET", "AppointmentController", "showAppointmentsManage");

// Doctor
$router->addRoute("doctor/save", "GET", "DoctorController", "showDoctorCreation");
$router->addRoute("doctor", "POST", "DoctorController", "saveDoctor");
$router->addRoute("doctor/:ID/update", "POST", "DoctorController", "updateDoctor");

// Specialization
$router->addRoute("specialization/save", "GET", "SpecializationController", "showSpecializationCreation");
$router->addRoute("specialization", "POST", "SpecializationController", "saveSpecialization");
$router->addRoute("specialization/:ID/update", "POST", "SpecializationController", "updateSpecialization");

// Hospital
$router->addRoute("hospital/save", "GET", "HospitalController", "showHospitalCreation");
$router->addRoute("hospital", "POST", "HospitalController", "saveHospital");
$router->addRoute("hospital/:ID/update", "POST", "HospitalController", "updateHospital");

$router->route($_GET["action"], $_SERVER["REQUEST_METHOD"]);
?>