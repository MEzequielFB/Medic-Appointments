<?php
require_once "app/controller/Controller.php";
require_once "app/controller/AuthHelper.php";
require_once "app/controller/TimesHelper.php";
require_once "app/model/AppointmentModel.php";
require_once "app/model/StatusModel.php";
require_once "app/model/DoctorModel.php";
require_once "app/view/AppointmentView.php";

class AppointmentController extends Controller {
    private $statusModel;
    private $doctorModel;
    private $authHelper;

    function __construct() {
        $this->model = new AppointmentModel();
        $this->statusModel = new StatusModel();
        $this->doctorModel = new DoctorModel();
        $this->view = new AppointmentView();
        $this->authHelper = new AuthHelper();

        $this->authHelper->checkLoggedUser();
    }

    public function showAllUpcomingAppointmentsByUser() {
        $userId = $this->authHelper->getUserId();
        $nearest = $this->model->findNearestAppointmentByUser($userId);
        $appointments = $this->model->findAllUpcomingAppointmentsByUser($userId);

        $this->view->showAppointments($appointments, $nearest);
    }

    public function showAppointmentCreation() {
        $this->view->showAppointmentCreation();
    }

    public function showAppointmentReschedule($params = null) {
        $appointmentId = $params[":ID"];
        $appointment = $this->model->findAppointmentById($appointmentId);
        if (!$appointment) {
            header("Location: " . BASE_URL . "appointments");
            die();
        }

        if ($appointment->user_id != $this->authHelper->getUserId()) {
            header("Location: " . BASE_URL . "appointments");
            die();
        }

        if ($appointment->status != "to be confirmed" && $appointment->status != "confirmed") {
            header("Location: " . BASE_URL . "appointments");
            die();
        }

        // Only admins and superadmins can reschedule non consultation appointments
        if (strtolower($appointment->reason) != "consultation" && ($this->authHelper->getUserRole() != "ADMIN" && $this->authHelper->getUserRole() != "SUPERADMIN")) {
            header("Location: " . BASE_URL . "appointments");
            die();
        }

        $doctor = $this->doctorModel->findDoctorById($appointment->doctor_id);
        if (!$doctor) {
            header("Location: " . BASE_URL . "appointments");
            die();
        }

        $doctorAppointmentsTime = $this->model->findAppointmentsTimeByDateAndDoctor($appointment->date, $appointment->doctor_id);
        $timesHelper = new TimesHelper($doctor);

        $availableDoctorTimes = $timesHelper->getAvailableTimes($doctorAppointmentsTime);

        $this->view->showAppointmentCreation($appointment, $availableDoctorTimes);
    }

    public function cancelAppointment($params = null) {
        $appointmentId = $params[":ID"];
        $appointment = $this->model->findAppointmentById($appointmentId);
        if (!$appointment) {
            header("Location: " . BASE_URL . "appointments");
            die();
        }

        if ($appointment->user_id != $this->authHelper->getUserId()) {
            header("Location: " . BASE_URL . "appointments");
            die();
        }

        $statusCancelled = $this->statusModel->findStatusByName("cancelled");
        if (!$statusCancelled) {
            header("Location: " . BASE_URL . "appointments");
            die();
        }

        $this->model->cancelAppointment($statusCancelled->id, $appointmentId);
        header("Location: " . BASE_URL . "appointments");
    }
}
?>