<?php
require_once "app/model/DoctorModel.php";
require_once "app/model/SpecializationModel.php";
require_once "app/model/HospitalModel.php";
require_once "app/view/DoctorView.php";
require_once "app/controller/Controller.php";

class DoctorController extends Controller {
    private $specializationModel;
    private $hospitalModel;

    function __construct() {
        $this->model = new DoctorModel();
        $this->view = new DoctorView();
        $this->specializationModel = new SpecializationModel();
        $this->hospitalModel = new HospitalModel();
    }

    public function showDoctorCreation() {
        $specializations = $this->specializationModel->findAllSpecializations();
        $hospitals = $this->hospitalModel->findAllHospitals();
        $this->view->showDoctorCreation($specializations, $hospitals);
    }

    public function saveDoctor() {
        $emptyFields = $this->checkRequiredFields(["fullname", "image", "specialization", "hospital"]);
        if (!isset($_FILES["image"])) {
            array_push($emptyFields, "image");
        }
        if (!empty($emptyFields)) {
            $this->view->showDoctorCreation("The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $fullname = $_POST["fullname"];
        $specialization = $_POST["specialization"];
        $hospital = $_POST["hospital"];

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "image/profile/" . $filename;
        $validExtensions = ["png", "jpg", "jpeg"];

        $isValidFile = $this->checkFileExtension($filename, $validExtensions);
        if (!$isValidFile) {
            $this->view->showDoctorCreation("Invalid extension file! Allowed extensions: " . implode(", ", $validExtensions));
            die();
        }

        $this->model->saveDoctor($fullname, $filename, $specialization, $hospital);

        if (!move_uploaded_file($tempname, $folder)) {
            $this->view->showDoctorCreation("Error while uploading image");
            die();
        }

        header("Location: " . BASE_URL . "doctor/save");
    }
}
?>