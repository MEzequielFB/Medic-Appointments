<?php
class AuthHelper {

    function __construct() {
        session_start();
    }

    public function login($user) {
        $_SESSION["ID"] = $user->id;
        $_SESSION["EMAIL"] = $user->email;
        $_SESSION["ROLE"] = $user->role;
    }

    public function logout() {
        session_destroy();
    }

    public function checkLoggedUser() {
        if (!isset($_SESSION["ID"])) {
            header("Location: " . LOGIN);
            die();
        }
    }

    public function isUserLogged() {
        return isset($_SESSION["ID"]);
    }

    public function getUserId() {
        if (isset($_SESSION["ID"])) {
            return $_SESSION["ID"];
        }

        return null;
    }

    public function getUserEmail() {
        if (isset($_SESSION["EMAIL"])) {
            return $_SESSION["EMAIL"];
        }

        return null;
    }

    public function getUserRole() {
        if (isset($_SESSION["ROLE"])) {
            return $_SESSION["ROLE"];
        }

        return null;
    }
}
?>