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
}
?>