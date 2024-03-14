<?php
require_once "api/controller/ApiController.php";
require_once "api/controller/AuthHelper.php";
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

    public function saveAppointment() {
        $emptyFields = $this->checkRequiredFields(["doctorId", "date"]);
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

        $startTime = DateTime::createFromFormat('H:i:s', $doctor->start_time);
        $endTime = DateTime::createFromFormat('H:i:s', $doctor->end);

        $requestTime = $requestData->date->format('H:i:s');
        $requestTime = DateTime::createFromFormat('H:i:s', $requestTime);

        if ($requestTime < $startTime || $requestTime > $endTime) {
            return $this->view->response("Invalid time. The doctor $doctor->fullname is available at $doctor->start_time to $doctor->end_time", 400);
            /* return $this->view->response("The doctor $doctor->fullname is unavailable at $requestTime", 400); */
        }

        $this->model->saveAppointment($requestData->date, $requestData->doctorId, $status->id, $userId);
    }
}
?>