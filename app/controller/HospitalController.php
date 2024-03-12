<?php
require_once "app/controller/Controller.php";
require_once "app/view/HospitalView.php";

class HospitalController extends Controller {

    function __construct() {
        $this->model = new HospitalModel();
        $this->view = new HospitalView();
    }

    public function showHospitalCreation() {
        $this->view->showHospitalCreation();
    }

    public function saveHospital() {
        $emptyFields = $this->checkRequiredFields(["name", "address"]);
        if (!empty($emptyFields)) {
            $this->view->showHospitalCreation("The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $name = $_POST["name"];
        $address = $_POST["address"];

        $hospital = $this->model->findHospitalByName($name);
        if ($hospital) {
            $this->view->showHospitalCreation("A hospital with the name '$name' already exists");
            die();
        }

        $this->model->saveHospital($name, $address);

        header("Location " . BASE_URL . "hospital/save");
    }
}
?>