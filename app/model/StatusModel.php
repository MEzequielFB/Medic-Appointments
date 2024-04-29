<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class StatusModel {
    private $db;
    private $dotenv;

    function __construct() {
        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $this->dotenv->safeLoad();

        $this->db = new PDO('mysql:host=' . $_ENV["DB_HOSTNAME"] . ';port=' . $_ENV["DB_PORT"] . ';dbname=' . $_ENV["DB_NAME"] . ';charset=utf8', $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    public function findAllStatus() {
        $query = $this->db->prepare("SELECT * FROM status");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findStatusById($id) {
        $query = $this->db->prepare("SELECT * FROM status WHERE id = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findStatusByName($name) {
        $query = $this->db->prepare("SELECT * FROM status WHERE name = ?");
        $query->execute([$name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findAllStatusIds() {
        $query = $this->db->prepare("SELECT id FROM status");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveStatus($name) {
        $query = $this->db->prepare("INSERT INTO status(name) VALUES(?)");
        $query->execute([$name]);
    }
}
?>