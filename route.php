<?php
require_once "Router.php";
require_once "app/controller/UserController.php";
require_once "app/controller/AppointmentController.php";

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . "/");
define('LOGIN', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . "/login");
define('APPOINTMENTS', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . "/appointments");

$router = new Router();

// Authentication
$router->addRoute("login", "GET", "UserController", "showLogin");
$router->addRoute("logout", "GET", "UserController", "logoutUser");
$router->addRoute("authentication", "POST", "UserController", "authenticateUser");
$router->addRoute("signUp", "GET", "UserController", "showSignUp");

// User
$router->addRoute("user", "POST", "UserController", "saveUser");

// Appointments
$router->addRoute("appointments", "GET", "AppointmentController", "showAllUpcomingAppointmentsByUser");
$router->addRoute("appointments/make", "GET", "AppointmentController", "showAppointmentCreation");

$router->route($_GET["action"], $_SERVER["REQUEST_METHOD"]);
?>