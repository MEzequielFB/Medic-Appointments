<?php
require_once "api/controller/ApiController.php";
require_once "app/model/DoctorModel.php";

class DoctorApiController extends ApiController {

    function __construct() {
        parent::__construct();
        $this->model = new DoctorModel();
    }

    public function findAllDoctors() {
        $doctors = $this->model->findAllDoctors();
        $this->view->response($doctors, 200);
    }
}
?>