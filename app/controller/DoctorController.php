<?php
require_once "app/model/DoctorModel.php";
require_once "app/model/SpecializationModel.php";
require_once "app/model/HospitalModel.php";
require_once "app/view/DoctorView.php";
require_once "app/controller/Controller.php";

class DoctorController extends Controller {
    function __construct() {
        $this->model = new DoctorModel();
        $this->view = new DoctorView();
    }

    public function showDoctorCreation() {
        $this->view->showDoctorCreation();
    }

    public function saveDoctor() {
        $emptyFields = $this->checkRequiredFields(["fullname", "specialization", "hospital", "startTime", "endTime"]);

        if (!isset($_FILES["image"]["name"]) || empty($_FILES["image"]["name"])) {
            array_push($emptyFields, "image");
        }

        if (!empty($emptyFields)) {
            $this->view->showDoctorCreation("The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $fullname = $_POST["fullname"];
        $specialization = $_POST["specialization"];
        $hospital = $_POST["hospital"];
        $startTime = $_POST["startTime"];
        $endTime = $_POST["endTime"];

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "image/profile/" . $filename;
        $validExtensions = ["png", "jpg", "jpeg"];

        $isValidFile = $this->checkFileExtension($filename, $validExtensions);
        if (!$isValidFile) {
            $this->view->showDoctorCreation("Invalid extension file! Allowed extensions: " . implode(", ", $validExtensions));
            die();
        }

        $this->model->saveDoctor($fullname, $filename, $startTime, $endTime, $specialization, $hospital);

        if (!move_uploaded_file($tempname, $folder)) {
            $this->view->showDoctorCreation("Error while uploading image");
            die();
        }

        header("Location: " . BASE_URL . "doctor/save");
    }
}
?>