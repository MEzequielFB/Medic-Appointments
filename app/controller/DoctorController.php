<?php
require_once "app/model/DoctorModel.php";
require_once "app/view/DoctorView.php";
require_once "app/controller/Controller.php";

class DoctorController extends Controller {

    function __construct() {
        $this->model = new DoctorModel();
        $this->view = new DoctorView();
    }

    public function saveDoctor() {
        $emptyFields = $this->checkRequiredFields(["fullname", "image", "specialization", "hospital"]);
        if (!isset($_FILES["image"])) {
            array_push($emptyFields, "image");
        }
        if (!empty($emptyFields)) {
            $this->view->showLogin("The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $fullname = $_POST["fullname"];
        $specialization = $_POST["specialization"];
        $hospital = $_POST["hospital"];

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "image/profile/" . $filename;

        $insertedId = $this->model->saveDoctor($fullname, $filename, $specialization, $hospital);

        if (!move_uploaded_file($tempname, $folder)) {
            $this->view->showLogin("Error while uploading image");
            die();
        }
    }
}
?>