<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class RoleModel {
    private $db;
    private $dotenv;

    function __construct() {
        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $this->dotenv->safeLoad();

        $this->db = new PDO('mysql:host=' . $_ENV["DB_HOSTNAME"] . ';dbname=' . $_ENV["DB_NAME"] . ';charset=utf8', $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    public function findAllRoles() {
        $query = $this->db->prepare("SELECT * FROM role");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllRolesNames() {
        $query = $this->db->prepare("SELECT name FROM role");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findRoleById($roleId) {
        $query = $this->db->prepare("SELECT * FROM role WHERE id = ?");
        $query->execute([$roleId]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findRoleByName($name) {
        $query = $this->db->prepare("SELECT * FROM role WHERE name = ?");
        $query->execute([$name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
?>