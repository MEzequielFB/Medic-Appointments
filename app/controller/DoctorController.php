<?php
require_once __DIR__ . "/../model/DoctorModel.php";
require_once __DIR__ . "/../model/SpecializationModel.php";
require_once __DIR__ . "/../model/HospitalModel.php";
require_once __DIR__ . "/../view/DoctorView.php";
require_once __DIR__ . "/../controller/Controller.php";
require_once __DIR__ . "/../controller/AuthHelper.php";

require_once __DIR__ . '/../../vendor/autoload.php';

use Cloudinary\Cloudinary;

class DoctorController extends Controller {
    private $authHelper;

    // Dependencies
    private $dotenv;
    private $cloudinary;

    function __construct() {
        $this->model = new DoctorModel();

        $this->authHelper = new AuthHelper();
        $this->authHelper->checkIsAdmin();

        $this->view = new DoctorView($this->authHelper->getUserUsername(), $this->authHelper->getUserRole(), $this->authHelper->getUserImage());

        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $this->dotenv->safeLoad();
        $this->cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => $_ENV["CLOUDINARY_CLOUD_NAME"],
                    'api_key'    => $_ENV["CLOUDINARY_API_KEY"],
                    'api_secret' => $_ENV["CLOUDINARY_API_SECRET"]
                ],
            ]
        );
    }

    public function showDoctorCreation() {
        $doctors = $this->model->findAllDoctors();
        $this->view->showDoctorCreation($doctors);
    }

    public function saveDoctor() {
        $emptyFields = $this->checkRequiredFields(["fullname", "specialization", "hospital", "startTime", "endTime"]);

        if (!isset($_FILES["image"]["name"]) || empty($_FILES["image"]["name"])) {
            array_push($emptyFields, "image");
        }

        if (!empty($emptyFields)) {
            $doctors = $this->model->findAllDoctors();
            $this->view->showDoctorCreation($doctors, "The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $fullname = $_POST["fullname"];
        $specialization = $_POST["specialization"];
        $hospital = $_POST["hospital"];
        $startTime = $_POST["startTime"];
        $endTime = $_POST["endTime"];

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $validExtensions = ["png", "jpg", "jpeg"];

        $isValidFile = $this->checkFileExtension($filename, $validExtensions);
        if (!$isValidFile) {
            $doctors = $this->model->findAllDoctors();
            $this->view->showDoctorCreation($doctors, "Invalid extension file! Allowed extensions: " . implode(", ", $validExtensions));
            die();
        }

        $uploadResponse = $this->cloudinary->uploadApi()->upload($tempname);
        $this->model->saveDoctor($fullname, $uploadResponse["secure_url"], $startTime, $endTime, $specialization, $hospital);

        header("Location: " . BASE_URL . "/doctor/save");
    }

    public function updateDoctor($params = null) {
        $doctorId = $params[":ID"];
        $doctor = $this->model->findDoctorById($doctorId);
        if (!$doctor) {
            $doctors = $this->model->findAllDoctors();
            $this->view->showDoctorCreation($doctors, "The specified doctor it doesn't exists");
            die();
        }

        $emptyFields = $this->checkRequiredFields(["fullname", "specialization", "hospital", "startTime", "endTime"]);

        if (!empty($emptyFields)) {
            $doctors = $this->model->findAllDoctors();
            $this->view->showDoctorCreation($doctors, "The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $fullname = $_POST["fullname"];
        $specialization = $_POST["specialization"];
        $hospital = $_POST["hospital"];
        $startTime = $_POST["startTime"];
        $endTime = $_POST["endTime"];

        $uploadResponse = [
            "secure_url" => $doctor->image
        ];

        if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
            $filename = $_FILES["image"]["name"];
            $tempname = $_FILES["image"]["tmp_name"];
            $validExtensions = ["png", "jpg", "jpeg"];

            $isValidFile = $this->checkFileExtension($filename, $validExtensions);
            if (!$isValidFile) {
                $doctors = $this->model->findAllDoctors();
                $this->view->showDoctorCreation($doctors, "Invalid extension file! Allowed extensions: " . implode(", ", $validExtensions));
                die();
            }

            $uploadResponse = $this->cloudinary->uploadApi()->upload($tempname);
        }

        $this->model->updateDoctor($fullname, $uploadResponse["secure_url"], $startTime, $endTime, $specialization, $hospital, $doctorId);

        header("Location: " . BASE_URL . "/doctor/save");
    }
}
?>