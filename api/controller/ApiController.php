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
}
?>