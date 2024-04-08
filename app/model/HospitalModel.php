<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class HospitalModel {
    private $db;
    private $dotenv;

    function __construct() {
        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $this->dotenv->safeLoad();

        $this->db = new PDO('mysql:host=' . $_ENV["DB_HOSTNAME"] . ';dbname=' . $_ENV["DB_NAME"] . ';charset=utf8', $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    public function findAllHospitals() {
        $query = $this->db->prepare("SELECT * FROM hospital");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findHospitalByName($name) {
        $query = $this->db->prepare("SELECT * FROM hospital WHERE name = ?");
        $query->execute([$name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findHospitalById($hospitalId) {
        $query = $this->db->prepare("SELECT * FROM hospital WHERE id = ?");
        $query->execute([$hospitalId]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function saveHospital($name, $address) {
        $query = $this->db->prepare("INSERT INTO hospital(name, address) VALUES(?,?)");
        $query->execute([$name, $address]);
    }

    public function updateHospital($name, $address, $hospitalId) {
        $query = $this->db->prepare("UPDATE hospital SET name = ?, address = ? WHERE id = ?");
        $query->execute([$name, $address, $hospitalId]);
    }
}
?>