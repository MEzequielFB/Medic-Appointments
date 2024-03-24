<?php
require_once "api/view/ApiView.php";

class ApiController {
    protected $model;
    protected $view;

    private $requestData;

    function __construct() {
        $this->view = new ApiView();
        $this->requestData = file_get_contents("php://input");
    }

    protected function getRequestData() {
        return json_decode($this->requestData);
    }

    protected function checkRequiredFields($requiredFields) {
        $emptyFields = [];
        $requestData = $this->getRequestData();

        foreach ($requiredFields as $field) {
            if (!isset($requestData->$field) || empty($requestData->$field)) {
                array_push($emptyFields, $field);
            }
        }

        return $emptyFields;
    }

    protected function checkFileExtension($filename, $validExtensions) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array($ext, $validExtensions);
    }
}
?>