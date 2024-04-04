<?php
/* require_once "app/model/UserModel.php";
require_once "../model/UserModel.php"; */
require_once __DIR__ . "/../model/UserModel.php";
require_once __DIR__ . "/../model/RoleModel.php";
require_once __DIR__ . "/../view/UserView.php";
require_once __DIR__ . "/../controller/AuthHelper.php";
require_once __DIR__ . "/../controller/Controller.php";

class UserController extends Controller {
    private $authHelper;
    private $roleModel;

    function __construct() {
        $this->model = new UserModel();
        $this->roleModel = new RoleModel();

        $this->authHelper = new AuthHelper();

        $this->view = new UserView($this->authHelper->getUserId(), $this->authHelper->getUserUsername(), $this->authHelper->getUserRole(), $this->authHelper->getUserImage());
        
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

    public function showUsersManage() {
        $this->authHelper->checkIsAdmin();

        $users = $this->model->findAllUsers();
        $roles = $this->roleModel->findAllRoles();

        $this->view->showUsersManage($users, $roles);
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
            $this->view->showSignUp("The following fields are empty: " . implode(", ", $emptyFields));
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

    public function updateProfileImage() {
        $userId = $this->authHelper->getUserId();
        $user = $this->model->findUserById($userId);
        if (!$user) {
            header("Location: " . BASE_URL . "settings");
            die();
        }

        $emptyFields = [];

        if (!isset($_FILES["image"]["name"]) || empty($_FILES["image"]["name"])) {
            array_push($emptyFields, "image");
        }

        if (!empty($emptyFields)) {
            $this->view->showSettings($user, "The following fields are empty: " . implode(", ", $emptyFields));
            die();
        }

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "image/profile/" . $filename;
        $validExtensions = ["png", "jpg", "jpeg"];

        $isValidFile = $this->checkFileExtension($filename, $validExtensions);
        if (!$isValidFile) {
            $this->view->showSettings($user, "Invalid extension file! Allowed extensions: " . implode(", ", $validExtensions));
            die();
        }

        if (!move_uploaded_file($tempname, $folder)) {
            $this->view->showSettings($user, "Error while uploading the file");
            die();
        }

        $this->model->updateProfileImage($filename, $userId);

        $user = $this->model->findUserById($userId);
        $this->authHelper->login($user); // To update the session attributes

        $this->view->showSettings($user, "", "Profile picture updated!");
    }
}
?>