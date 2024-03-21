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

    public function findHospitalById($params = null) {
        $hospitalId = $params[":ID"];
        $hospital = $this->model->findHospitalById($hospitalId);
        if (!$hospital) {
            return $this->view->response("The specified hospital doesn't exist", 404);
        }

        return $this->view->response($hospital, 200);
    }
}
?>