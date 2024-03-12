<?php
require_once "Router.php";
require_once "api/controller/DoctorApiController.php";

$router = new Router();

// Doctor
$router->addRoute("doctor", "GET", "DoctorApiController", "findAllDoctors");

$router->route($_GET["resource"], $_SERVER["REQUEST_METHOD"]);
?>