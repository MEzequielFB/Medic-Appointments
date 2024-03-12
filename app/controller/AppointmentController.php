<?php
require_once "app/controller/Controller.php";
require_once "app/controller/AuthHelper.php";
require_once "app/model/AppointmentModel.php";
require_once "app/view/AppointmentView.php";

class AppointmentController extends Controller {
    private $authHelper;

    function __construct() {
        $this->model = new AppointmentModel();
        $this->view = new AppointmentView();
        $this->authHelper = new AuthHelper();

        $this->authHelper->checkLoggedUser();
    }

    public function showAllUpcomingAppointmentsByUser() {
        $userId = $this->authHelper->getUserId();
        $appointments = $this->model->findAllUpcomingAppointmentsByUser($userId);

        $this->view->showAppointments($appointments);
    }

    public function showAppointmentCreation() {
        $this->view->showAppointmentCreation();
    }
}
?>