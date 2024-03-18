<?php
require_once "app/controller/Controller.php";
require_once "app/controller/AuthHelper.php";
require_once "app/model/AppointmentModel.php";
require_once "app/model/StatusModel.php";
require_once "app/view/AppointmentView.php";

class AppointmentController extends Controller {
    private $statusModel;
    private $authHelper;

    function __construct() {
        $this->model = new AppointmentModel();
        $this->statusModel = new StatusModel();
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
}
?>