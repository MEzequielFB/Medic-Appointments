<?php
class AuthHelper {

    function __construct() {
        session_start();
    }

    public function login($user) {
        $_SESSION["ID"] = $user->id;
        $_SESSION["EMAIL"] = $user->email;
        $_SESSION["USERNAME"] = $user->username;
        $_SESSION["ROLE"] = $user->role;
        $_SESSION["IMAGE"] = $user->image;
    }

    public function logout() {
        session_destroy();
    }

    public function checkLoggedUser() {
        if (!isset($_SESSION["ID"])) {
            header("Location: login");
            die();
        }
    }

    public function checkIsAdmin() {
        if (!isset($_SESSION["ROLE"]) || ($_SESSION["ROLE"] != "ADMIN" && $_SESSION["ROLE"] != "SUPER_ADMIN")) {
            header("Location: appointments");
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

    public function getUserUsername() {
        if (isset($_SESSION["USERNAME"])) {
            return $_SESSION["USERNAME"];
        }

        return null;
    }

    public function getUserRole() {
        if (isset($_SESSION["ROLE"])) {
            return $_SESSION["ROLE"];
        }

        return null;
    }

    public function getUserImage() {
        if (isset($_SESSION["IMAGE"])) {
            return $_SESSION["IMAGE"];
        }

        return null;
    }
}
?>