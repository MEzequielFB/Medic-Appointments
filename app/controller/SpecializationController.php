<?php
require_once "app/controller/Controller.php";
require_once "app/model/SpecializationModel.php";
require_once "app/view/SpecializationView.php";

class SpecializationController extends Controller {

    function __construct() {
        $this->model = new SpecializationModel();
        $this->view = new SpecializationView();
    }

    public function showSpecializationCreation(){
        $this->view->showSpecializationCreation();
    }

    public function saveSpecialization() {
        $emptyFields = $this->checkRequiredFields(["name"]);
        if (!empty($emptyFields)) {
            $this->view->showSpecializationCreation("The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $name = $_POST["name"];

        $specialization = $this->model->findSpecializationByName($name);
        if ($specialization) {
            $this->view->showSpecializationCreation("A specialization with the name '$name' already exists");
            die();
        }

        $this->model->saveSpecialization($name);

        header("Location: " . BASE_URL . "specialization/save");
    }
}
?>