<?php
require_once "api/controller/ApiController.php";
require_once "app/model/DoctorModel.php";

class DoctorApiController extends ApiController {

    function __construct() {
        parent::__construct();
        $this->model = new DoctorModel();
    }

    public function findAllDoctors() {
        $doctors = $this->model->findAllDoctors();
        $this->view->response($doctors, 200);
    }

    /* public function saveDoctor() {
        $emptyFields = $this->checkRequiredFields(["fullname", "image", "specialization", "hospital"]);
        if (!isset($_FILES["image"])) {
            array_push($emptyFields, "image");
        }

        if (!empty($emptyFields)) {
            return $this->view->response("The following fields are empty: " . implode(", ", $emptyFields), 400);
        }

        $fullname = $_POST["fullname"];
        $specialization = $_POST["specialization"];
        $hospital = $_POST["hospital"];

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "image/profile/" . $filename;

        $this->model->saveDoctor($fullname, $filename, $specialization, $hospital);

        if (!move_uploaded_file($tempname, $folder)) {
            return $this->view->response("Error while uploading image", 500);
        }

        $doctors = $this->model->findAllDoctors();
        return $this->view->response($doctors, 200);
    } */
}
?>