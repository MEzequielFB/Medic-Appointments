<?php
require_once "app/controller/Controller.php";
require_once "app/controller/AuthHelper.php";
require_once "app/model/SpecializationModel.php";
require_once "app/view/SpecializationView.php";

class SpecializationController extends Controller {
    private $authHelper;

    function __construct() {
        $this->model = new SpecializationModel();

        $this->authHelper = new AuthHelper();
        $this->authHelper->checkIsAdmin();

        $this->view = new SpecializationView($this->authHelper->getUserUsername(), $this->authHelper->getUserRole());
    }

    public function showSpecializationCreation(){
        $specializations = $this->model->findAllSpecializations();
        $this->view->showSpecializationCreation($specializations);
    }

    public function saveSpecialization() {
        $emptyFields = $this->checkRequiredFields(["name"]);
        if (!empty($emptyFields)) {
            $specializations = $this->model->findAllSpecializations();
            $this->view->showSpecializationCreation($specializations, "The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $name = $_POST["name"];

        $specialization = $this->model->findSpecializationByName($name);
        if ($specialization) {
            $specializations = $this->model->findAllSpecializations();
            $this->view->showSpecializationCreation($specializations, "A specialization with the name '$name' already exists");
            die();
        }

        $this->model->saveSpecialization($name);

        header("Location: " . BASE_URL . "specialization/save");
    }
}
?>