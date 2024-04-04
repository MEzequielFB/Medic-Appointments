<?php
require_once __DIR__ . "/../controller/Controller.php";
require_once __DIR__ . "/../controller/AuthHelper.php";
require_once __DIR__ . "/../view/HospitalView.php";

class HospitalController extends Controller {
    private $authHelper;

    function __construct() {
        $this->model = new HospitalModel();

        $this->authHelper = new AuthHelper();
        $this->authHelper->checkIsAdmin();

        $this->view = new HospitalView($this->authHelper->getUserUsername(), $this->authHelper->getUserRole(), $this->authHelper->getUserImage());
    }

    public function showHospitalCreation() {
        $hospitals = $this->model->findAllHospitals();
        $this->view->showHospitalCreation($hospitals);
    }

    public function saveHospital() {
        $emptyFields = $this->checkRequiredFields(["name", "address"]);
        if (!empty($emptyFields)) {
            $hospitals = $this->model->findAllHospitals();
            $this->view->showHospitalCreation($hospitals, "The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $name = $_POST["name"];
        $address = $_POST["address"];

        $hospital = $this->model->findHospitalByName($name);
        if ($hospital) {
            $hospitals = $this->model->findAllHospitals();
            $this->view->showHospitalCreation($hospitals, "A hospital with the name '$name' already exists");
            die();
        }

        $this->model->saveHospital($name, $address);

        header("Location: hospital/save");
    }

    public function updateHospital($params = null) {
        $hospitalId = $params[":ID"];
        $hospital = $this->model->findHospitalById($hospitalId);
        if (!$hospital) {
            $hospitals = $this->model->findAllHospitals();
            $this->view->showHospitalCreation($hospitals, "The specified hospital doesn't exist");
            die();
        }

        $emptyFields = $this->checkRequiredFields(["name", "address"]);
        if (!empty($emptyFields)) {
            $hospitals = $this->model->findAllHospitals();
            $this->view->showHospitalCreation($hospitals, "The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $name = $_POST["name"];
        $address = $_POST["address"];

        $hospital = $this->model->findHospitalByName($name);
        if ($hospital) {
            $hospitals = $this->model->findAllHospitals();
            $this->view->showHospitalCreation($hospitals, "A hospital with the name '$name' already exists");
            die();
        }

        $this->model->updateHospital($name, $address, $hospitalId);

        header("Location: hospital/save");
    }
}
?>