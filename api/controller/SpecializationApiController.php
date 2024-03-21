<?php
require_once "api/controller/ApiController.php";
require_once "app/model/SpecializationModel.php";

class SpecializationApiController extends ApiController {

    function __construct() {
        parent::__construct();
        $this->model = new SpecializationModel();
    }

    public function findAllSpecializations(){
        $specializations = $this->model->findAllSpecializations();
        $this->view->response($specializations, 200);
    }

    public function findSpecializationById($params = null) {
        $specializationId = $params[":ID"];
        $specialization = $this->model->findSpecializationById($specializationId);
        if (!$specialization) {
            return $this->view->response("The specified specialization doesn't exist", 404);
        }

        return $this->view->response($specialization, 200);
    }
}   
?>