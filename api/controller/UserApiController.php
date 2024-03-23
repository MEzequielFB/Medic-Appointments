<?php
require_once "api/controller/ApiController.php";
require_once "app/model/UserModel.php";
require_once "app/model/RoleModel.php";

class UserApiController extends ApiController {
    private $roleModel;

    function __construct() {
        parent::__construct();
        $this->model = new UserModel();
        $this->roleModel = new RoleModel();
    }

    // Users with role USER
    public function findAllUsers() {
        $role = $this->roleModel->findRoleByName("USER");
        if (!$role) {
            return $this->view->response("Server error", 500);
        }

        $users = $this->model->findAllUsersByRole($role->name);
        return $this->view->response($users, 200);
    }
}
?>