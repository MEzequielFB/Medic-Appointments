<?php
require_once "api/controller/ApiController.php";
require_once "app/model/HospitalModel.php";

class HospitalApiController extends ApiController {

    function __construct() {
        parent::__construct();
        $this->model = new HospitalModel();
    }

    public function findAllHospitals() {
        $hospitals = $this->model->findAllHospitals();
        $this->view->response($hospitals, 200);
    }
}
?>