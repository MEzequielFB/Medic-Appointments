<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class SpecializationModel {
    private $db;
    private $dotenv;

    function __construct() {
        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $this->dotenv->safeLoad();

        $this->db = new PDO('mysql:host=' . $_ENV["DB_HOSTNAME"] . ';port=' . $_ENV["DB_PORT"] . ';dbname=' . $_ENV["DB_NAME"] . ';charset=utf8', $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    public function findAllSpecializations() {
        $query = $this->db->prepare("SELECT * FROM specialization");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findSpecializationByName($name) {
        $query = $this->db->prepare("SELECT * FROM specialization WHERE name = ?");
        $query->execute([$name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findSpecializationById($specializationId) {
        $query = $this->db->prepare("SELECT * FROM specialization WHERE id = ?");
        $query->execute([$specializationId]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function saveSpecialization($name) {
        $query = $this->db->prepare("INSERT INTO specialization(name) VALUES(?)");
        $query->execute([$name]);
    }

    public function updateSpecialization($name, $specializationId) {
        $query = $this->db->prepare("UPDATE specialization SET name = ? WHERE id = ?");
        $query->execute([$name, $specializationId]);
    }
}
?>