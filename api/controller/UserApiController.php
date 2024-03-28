<?php
require_once "api/controller/ApiController.php";
require_once "app/controller/AuthHelper.php";
require_once "app/model/UserModel.php";
require_once "app/model/RoleModel.php";

class UserApiController extends ApiController {
    private $roleModel;
    private $authHelper;

    function __construct() {
        parent::__construct();
        $this->model = new UserModel();
        $this->roleModel = new RoleModel();
        $this->authHelper = new AuthHelper();
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

    public function findAllUsersByFilter() {
        $requestData = $this->getRequestData();

        $roles = explode("", $requestData->role);
        if (empty($requestData->role)) {
            $roles = $this->roleModel->findAllRolesNames(); 
        }

        $users = $this->model->findAllUsersByFilter($requestData->filter, $roles);
        return $this->view->response($users, 200);
    }

    public function updateUserInformation() {
        $this->authHelper->checkLoggedUser();

        $userId = $this->authHelper->getUserId();
        $user = $this->model->findUserById($userId);
        if (!$user) {
            return $this->view->response("The specified user doesn't exist", 404);
        }

        $emptyFields = $this->checkRequiredFields(["email", "username"]);
        if (!empty($emptyFields)) {
            return $this->view->response("The following fields are empty: " . implode(", ", $emptyFields), 400);
        }

        $requestData = $this->getRequestData();

        $existingUser = $this->model->findUserByEmail($requestData->email);
        if ($existingUser && $existingUser->id != $userId) {
            return $this->view->response("The email '$requestData->email' is already in use", 400);
        }

        $this->model->updateProfileInformation($requestData->email, $requestData->username, $userId);

        $user = $this->model->findUserById($userId);
        $this->authHelper->login($user);

        return $this->view->response($user, 200);
    }

    public function updatePassword() {
        $userId = $this->authHelper->getUserId();
        $user = $this->model->findUserById($userId);
        if (!$user) {
            return $this->view->response("The specified user doesn't exist", 404);
        }

        $emptyFields = $this->checkRequiredFields(["password", "newPassword", "newPasswordConfirm"]);
        if (!empty($emptyFields)) {
            return $this->view->response("The following fields are empty: " . implode(", ", $emptyFields), 400);
        }

        $requestData = $this->getRequestData();

        if (!password_verify($requestData->password, $user->password)) {
            return $this->view->response("Invalid password", 400);
        }

        if ($requestData->newPassword != $requestData->newPasswordConfirm) {
            return $this->view->response("The passwords do not match", 400);
        }

        $hashedPassword = password_hash($requestData->newPassword, PASSWORD_BCRYPT);

        $this->model->updateUserPassword($hashedPassword, $userId);
        return $this->view->response("The password has been updated!", 200);
    }

    public function updateUserRole($params = null) {
        $loggedUserRole = $this->authHelper->getUserRole();
        if ($loggedUserRole != "SUPER_ADMIN") {
            return $this->view->response("You don't have the permissions to update users roles", 403);
        }

        $loggedUserId = $this->authHelper->getUserId();
        $userId = $params[":ID"];

        if ($loggedUserId == $userId) {
            return $this->view->response("You cannot update your own role", 400);
        }

        $user = $this->model->findUserById($userId);
        if (!$user) {
            return $this->view->response("The specified user doesn't exist", 404);
        }

        $requestData = $this->getRequestData();

        $role = $this->roleModel->findRoleById($requestData->roleId);
        if (!$role) {
            return $this->view->response("The specified role doesn't exist", 404);
        }

        if ($user->role == $role->name) {
            return $this->view->response("The user with email '$user->email' already has the selected role ($role->name)", 400);
        }

        $this->model->updateUserRole($role->id, $userId);
        return $this->view->response("The role of the user with email '$user->email' has been changed from '$user->role' to '$role->name'", 200);
    }
}
?>