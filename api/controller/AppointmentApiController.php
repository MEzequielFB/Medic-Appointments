<?php
require_once "api/controller/ApiController.php";
require_once "app/controller/AuthHelper.php";
require_once "app/model/AppointmentModel.php";
require_once "app/model/DoctorModel.php";
require_once "app/model/StatusModel.php";

class AppointmentApiController extends ApiController {
    private $doctorModel;
    private $statusModel;
    private $authHelper;

    function __construct() {
        parent::__construct();
        $this->model = new AppointmentModel();
        $this->doctorModel = new DoctorModel();
        $this->statusModel = new StatusModel();
        $this->authHelper = new AuthHelper();
    }

    public function findAllCompletedAppointmentsByUser() {
        $userId = $this->authHelper->getUserId();
        $appointments = $this->model->findAllCompletedAppointmentsByUser($userId);

        $this->view->response($appointments, 200);
    }

    public function findAllCancelledAppointmentsByUser() {
        $userId = $this->authHelper->getUserId();
        $appointments = $this->model->findAllCancelledAppointmentsByUser($userId);

        $this->view->response($appointments, 200);
    }

    public function findAllAppointmentsByDoctor($params = null) {
        $doctorId = $params[":DOCTOR_ID"];
        $appointments = $this->model->findAllAppointmentsByDoctor($doctorId);

        return $this->view->response($appointments, 200);
    }

    public function findAllAppointmentsByFilter() {
        $requestData = $this->getRequestData();
        if ($requestData->username == "" && $requestData->date == "" && $requestData->statusId == "") {
            $appointments = $this->model->findAllAppointmentsByDoctor($requestData->doctorId);
            return $this->view->response($appointments, 200);
        }

        $appointments = $this->model->findAllAppointmentsByFilter($requestData->username, $requestData->date, $requestData->statusId, $requestData->doctorId);

        return $this->view->response($appointments, 200);
    }

    public function saveAppointment() {
        $emptyFields = $this->checkRequiredFields(["date", "duration", "reason", "doctorId"]);
        if (!empty($emptyFields)) {
            return $this->view->response("The following fields are empty: " . implode(", ", $emptyFields), 400);
        }

        $requestData = $this->getRequestData();

        $status = $this->statusModel->findStatusByName("to be confirmed");
        if (!$status) {
            return $this->view->response("Server Error", 500);
        }

        $userId = $this->authHelper->getUserId();
        $doctor = $this->doctorModel->findDoctorById($requestData->doctorId);

        if (!$doctor) {
            return $this->view->response("The selected doctor doesn't exists or isn't available", 404);
        }

        date_default_timezone_set("America/Argentina/Buenos_Aires");

        $currentDate = date("Y-m-d");
        $currentTime = time();

        $dateArray = explode(" ", $requestData->date);
        $requestDate = $dateArray[0];
        $requestTime = strtotime($dateArray[1]);

        if ($currentDate === $requestDate) {
            if ($requestTime < $currentTime) {
                return $this->view->response("The selected time has already passed", 400);
            }
        } else if ($requestDate < $currentDate) {
            return $this->view->response("The selected date has already passed", 400);
        }
        
        $this->model->saveAppointment($requestData->date, $requestData->duration, $requestData->reason, $requestData->doctorId, $status->id, $userId);
    }

    public function rescheduleAppointment($params = null) {
        $appointmentId = $params[":ID"];
        $appointment = $this->model->findAppointmentById($appointmentId);
        if (!$appointment) {
            return $this->view->response("The appointment with id '$appointmentId' doesn't exist", 404);
        }

        if ($appointment->user_id != $this->authHelper->getUserId()) {
            return $this->view->response("Server Error", 500);
        }

        $requestData = $this->getRequestData();
        $status = $this->statusModel->findStatusByName("to be confirmed");
        if (!$status) {
            return $this->view->response("Server Error", 500);
        }

        $this->model->rescheduleAppointment($requestData->date, $requestData->duration, $requestData->reason, $status->id, $requestData->doctorId, $appointmentId);

        $this->view->response("Appointment rescheduled succesfully", 200);
    }
}   
?>