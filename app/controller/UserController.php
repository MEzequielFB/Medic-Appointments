<?php
require_once "app/model/UserModel.php";
require_once "app/model/RoleModel.php";
require_once "app/view/UserView.php";
require_once "app/controller/AuthHelper.php";

class UserController {
    private $model;
    private $view;
    private $authHelper;

    private $roleModel;

    function __construct() {
        $this->model = new UserModel();
        $this->view = new UserView();
        $this->authHelper = new AuthHelper();

        $this->roleModel = new RoleModel();
    }

    public function showLogin() {
        if ($this->authHelper->isUserLogged()) {
            header("Location: " . HOME);
        } else {
            $this->view->showLogin();
        }
    }

    public function showSignUp() {
        if ($this->authHelper->isUserLogged()) {
            header("Location: " . HOME);
        } else {
            $this->view->showSignUp();
        }
    }

    public function showHome() {
        $this->authHelper->checkLoggedUser();

        $users = $this->model->findAllUsers();
        $this->view->showHome($users);
    }

    public function logoutUser() {
        $this->authHelper->logout();

        header("Location: " . LOGIN);
    }

    public function authenticateUser() {
        $emptyFields = $this->checkRequiredFields(["email", "password"]);
        if (!empty($emptyFields)) {
            $this->view->showLogin("The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->model->findUserByEmail($email);
        if (!$user || !password_verify($password, $user->password)) {
            $this->view->showLogin("Invalid email or password");
            die();
        }

        $this->authHelper->login($user);
        header("Location: " . HOME);
    }

    public function saveUser() {
        $emptyFields = $this->checkRequiredFields(["email", "password", "passwordCheck"]);
        if (!empty($emptyFields)) {
            $this->view->showLogin("The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordCheck = $_POST["passwordCheck"];

        $user = $this->model->findUserByEmail($email);
        if ($user) {
            $this->view->showSignUp("The email '$email' is already in use");
            die();
        }

        if ($password != $passwordCheck) {
            $this->view->showSignUp("The passwords do not match");
            die();
        }

        $role = $this->roleModel->findRoleByName("USER");
        if (!$role) {
            $this->view->showSignUp("Internal Server Error");
            die();
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $insertedId = $this->model->saveUser($email, $hashedPassword, $role->id);
        $user = $this->model->findUserById($insertedId);

        $this->authHelper->login($user);

        header("Location: " . HOME);
    }

    private function checkRequiredFields($requiredFields) {
        $emptyFields = [];

        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                array_push($emptyFields, $field);
            }
        }

        return $emptyFields;
    }
}
?>