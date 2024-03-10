<?php
require_once "Router.php";
require_once "app/controller/UserController.php";

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']));
define('LOGIN', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . "/login");
define('HOME', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . "/home");

$router = new Router();

// Authentication
$router->addRoute("login", "GET", "UserController", "showLogin");
$router->addRoute("logout", "GET", "UserController", "logoutUser");
$router->addRoute("authentication", "POST", "UserController", "authenticateUser");
$router->addRoute("signUp", "GET", "UserController", "showSignUp");

// User
$router->addRoute("home", "GET", "UserController", "showHome");
$router->addRoute("user", "POST", "UserController", "saveUser");

$router->route($_GET["action"], $_SERVER["REQUEST_METHOD"]);
?>