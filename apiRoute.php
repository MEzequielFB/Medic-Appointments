<?php
require_once "Router.php";
require_once "api/controller/AppointmentApiController.php";
require_once "api/controller/DoctorApiController.php";
require_once "api/controller/SpecializationApiController.php";
require_once "api/controller/HospitalApiController.php";

$router = new Router();

// Appointment
$router->addRoute("appointment", "POST", "AppointmentApiController", "saveAppointment");
$router->addRoute("appointment/completed", "GET", "AppointmentApiController", "findAllCompletedAppointmentsByUser");
$router->addRoute("appointment/cancelled", "GET", "AppointmentApiController", "findAllCancelledAppointmentsByUser");
$router->addRoute("appointment/:ID/reschedule", "PUT", "AppointmentApiController", "rescheduleAppointment");

// Doctor
$router->addRoute("doctor", "GET", "DoctorApiController", "findAllDoctors");
$router->addRoute("doctor/search", "POST", "DoctorApiController", "findAllDoctorsByFilter");
$router->addRoute("doctor/:ID/times", "POST", "DoctorApiController", "findAllAvailableDoctorTimes");

// Specialization
$router->addRoute("specialization", "GET", "SpecializationApiController", "findAllSpecializations");

// Hospital
$router->addRoute("hospital", "GET", "HospitalApiController", "findAllHospitals");

$router->route($_GET["resource"], $_SERVER["REQUEST_METHOD"]);
?>