<?php
class RoleModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    }

    public function findAllRoles() {
        $query = $this->db->prepare("SELECT * FROM role");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findRoleByName($name) {
        $query = $this->db->prepare("SELECT * FROM role WHERE name = ?");
        $query->execute([$name]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
?>