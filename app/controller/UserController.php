<?php
require_once "app/model/UserModel.php";
require_once "app/model/RoleModel.php";
require_once "app/view/UserView.php";
require_once "app/controller/AuthHelper.php";
require_once "app/controller/Controller.php";

class UserController extends Controller {
    private $authHelper;
    private $roleModel;

    function __construct() {
        $this->model = new UserModel();
        $this->roleModel = new RoleModel();

        $this->authHelper = new AuthHelper();

        $this->view = new UserView($this->authHelper->getUserUsername(), $this->authHelper->getUserRole());
        
    }

    public function showLogin() {
        if ($this->authHelper->isUserLogged()) {
            header("Location: " . APPOINTMENTS);
        } else {
            $this->view->showLogin();
        }
    }

    public function showSignUp() {
        if ($this->authHelper->isUserLogged()) {
            header("Location: " . APPOINTMENTS);
        } else {
            $this->view->showSignUp();
        }
    }

    public function showSettings() {
        $this->authHelper->checkLoggedUser();

        $userId = $this->authHelper->getUserId();
        $user = $this->model->findUserById($userId);
        
        $this->view->showSettings($user);
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
        header("Location: " . APPOINTMENTS);
    }

    public function saveUser() {
        $emptyFields = $this->checkRequiredFields(["username", "email", "password", "passwordCheck"]);
        if (!empty($emptyFields)) {
            $this->view->showLogin("The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $username = $_POST["username"];
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

        $insertedId = $this->model->saveUser($username, $email, $hashedPassword, $role->id);
        $user = $this->model->findUserById($insertedId);

        $this->authHelper->login($user);

        header("Location: " . APPOINTMENTS);
    }
}
?>