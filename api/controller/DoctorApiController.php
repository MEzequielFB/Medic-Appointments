<?php
require_once "api/controller/ApiController.php";
require_once "app/model/DoctorModel.php";
require_once "app/model/AppointmentModel.php";
require_once "app/controller/TimesHelper.php";

class DoctorApiController extends ApiController {
    private $appointmentModel;

    function __construct() {
        parent::__construct();
        $this->model = new DoctorModel();
        $this->appointmentModel = new AppointmentModel();
    }

    public function findAllDoctors() {
        $doctors = $this->model->findAllDoctors();
        $this->view->response($doctors, 200);
    }

    public function findAllDoctorsByFilter() {
        $requestData = $this->getRequestData();
        $doctors = [];

        if ($requestData->filter == "") {
            $doctors = $this->model->findAllDoctors();
        } else {
            $doctors = $this->model->findAllDoctorsByFilter($requestData->filter);
        }

        return $this->view->response($doctors, 200);
    }

    public function findAllAvailableDoctorTimes($params = null) {
        $requestData = $this->getRequestData();
        $doctorId = $params[":ID"];

        $doctor = $this->model->findDoctorById($doctorId);
        if (!$doctor) {
            return $this->view->response("The doctor with id '$doctorId' doesn't exist", 404);
        }

        $times = $this->appointmentModel->findAppointmentsTimeByDateAndDoctor($requestData->date, $doctorId);

        $timesHelper = new TimesHelper($doctor);
        $availableTimes = $timesHelper->getAvailableTimes($times);

        return $this->view->response($availableTimes, 200);
    }
}
?>