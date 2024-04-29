<?php
require_once __DIR__ . "/../controller/Controller.php";
require_once __DIR__ . "/../controller/AuthHelper.php";
require_once __DIR__ . "/../model/SpecializationModel.php";
require_once __DIR__ . "/../view/SpecializationView.php";

class SpecializationController extends Controller {
    private $authHelper;

    function __construct() {
        $this->model = new SpecializationModel();

        $this->authHelper = new AuthHelper();
        $this->authHelper->checkIsAdmin();

        $this->view = new SpecializationView($this->authHelper->getUserUsername(), $this->authHelper->getUserRole(), $this->authHelper->getUserImage());
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

        header("Location: " . BASE_URL . "/specialization/save");
    }

    public function updateSpecialization($params = null) {
        $specializationId = $params[":ID"];
        $specialization = $this->model->findSpecializationById($specializationId);
        if (!$specialization) {
            $specializations = $this->model->findAllSpecializations();
            $this->view->showSpecializationCreation($specializations, "The specified specialization doesn't exist");
            die();
        }

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

        $this->model->updateSpecialization($name, $specializationId);

        header("Location: " . BASE_URL . "/specialization/save");
    }
}
?>