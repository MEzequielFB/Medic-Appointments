<?php
require_once __DIR__ . "/../controller/ApiController.php";
require_once __DIR__ . "/../../app/model/RoleModel.php";

class RoleApiController extends ApiController {

    function __construct() {
        parent::__construct();
        $this->model = new RoleModel();
    }

    public function findAllRoles() {
        $roles = $this->model->findAllRoles();
        return $this->view->response($roles, 200);
    }
}
?>