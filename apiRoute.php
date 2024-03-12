<?php
require_once "Router.php";
require_once "api/controller/DoctorApiController.php";
require_once "api/controller/SpecializationApiController.php";
require_once "api/controller/HospitalApiController.php";

$router = new Router();

// Doctor
$router->addRoute("doctor", "GET", "DoctorApiController", "findAllDoctors");

// Specialization
$router->addRoute("specialization", "GET", "SpecializationApiController", "findAllSpecializations");

// Hospital
$router->addRoute("hospital", "GET", "HospitalApiController", "findAllHospitals");

$router->route($_GET["resource"], $_SERVER["REQUEST_METHOD"]);
?>