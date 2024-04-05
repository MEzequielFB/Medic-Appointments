<?php
require_once __DIR__ . "/../controller/Controller.php";
require_once __DIR__ . "/../controller/AuthHelper.php";
require_once __DIR__ . "/../controller/TimesHelper.php";
require_once __DIR__ . "/../model/AppointmentModel.php";
require_once __DIR__ . "/../model/StatusModel.php";
require_once __DIR__ . "/../model/DoctorModel.php";
require_once __DIR__ . "/../view/AppointmentView.php";

class AppointmentController extends Controller {
    private $statusModel;
    private $doctorModel;
    private $authHelper;

    function __construct() {
        $this->model = new AppointmentModel();
        $this->statusModel = new StatusModel();
        $this->doctorModel = new DoctorModel();

        $this->authHelper = new AuthHelper();
        $this->authHelper->checkLoggedUser();

        $this->view = new AppointmentView($this->authHelper->getUserUsername(), $this->authHelper->getUserRole(), $this->authHelper->getUserImage());
    }

    public function showAllUpcomingAppointmentsByUser() {
        $userId = $this->authHelper->getUserId();

        $cancelledStatus = $this->statusModel->findStatusByName("cancelled");
        $completedStatus = $this->statusModel->findStatusByName("completed");
        $toBeConfirmedStatus = $this->statusModel->findStatusByName("to be confirmed");
        $confirmedStatus = $this->statusModel->findStatusByName("confirmed");

        $this->model->completePastAppointmentsByUser($completedStatus->id, $confirmedStatus->id, $userId);
        $this->model->cancelPastAppointmentsByUser($cancelledStatus->id, $toBeConfirmedStatus->id, $userId);

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
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        // Admins can reschedule any appointment
        if ($appointment->user_id != $this->authHelper->getUserId() && $this->authHelper->getUserRole() == "USER") {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        if ($appointment->status != "to be confirmed" && $appointment->status != "confirmed") {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        // Only admins and superadmins can reschedule non consultation appointments
        if (strtolower($appointment->reason) != "consultation" && ($this->authHelper->getUserRole() != "ADMIN" && $this->authHelper->getUserRole() != "SUPERADMIN")) {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        $doctor = $this->doctorModel->findDoctorById($appointment->doctor_id);
        if (!$doctor) {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        $doctorAppointmentsTime = $this->model->findAppointmentsTimeByDateAndDoctor($appointment->date, $appointment->doctor_id);
        $timesHelper = new TimesHelper($doctor);

        $availableDoctorTimes = $timesHelper->getAvailableTimes($doctorAppointmentsTime);

        $this->view->showAppointmentCreation($appointment, $availableDoctorTimes);
    }

    // ADMIN - SUPER_ADMIN
    public function showAppointmentsManage() {
        $this->authHelper->checkIsAdmin();
        
        $status = $this->statusModel->findAllStatus();

        $this->view->showAppointmentsManage($status);
    }

    public function cancelAppointment($params = null) {
        $appointmentId = $params[":ID"];
        $appointment = $this->model->findAppointmentById($appointmentId);
        if (!$appointment) {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        // Admins can cancel the appointment even if the logged user id is different from the appointment's user_id
        if ($appointment->user_id != $this->authHelper->getUserId() && $this->authHelper->getUserRole() == "USER") {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        $statusCancelled = $this->statusModel->findStatusByName("cancelled");
        if (!$statusCancelled) {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        $this->model->changeAppointmentStatus($statusCancelled->id, $appointmentId);
        header("Location: " . BASE_URL . "/appointments");
    }

    // Only admins can confirm appointments
    public function confirmAppointment($params = null) {
        $this->authHelper->checkIsAdmin();

        $appointmentId = $params[":ID"];
        $appointment = $this->model->findAppointmentById($appointmentId);
        if (!$appointment) {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        $statusConfirmed = $this->statusModel->findStatusByName("confirmed");
        if (!$statusConfirmed) {
            header("Location: " . BASE_URL . "/appointments");
            die();
        }

        $this->model->changeAppointmentStatus($statusConfirmed->id, $appointmentId);
        header("Location: appointments/manage");
    }
}
?>