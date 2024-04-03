<?php
class RoleModel {
    private $db;

    /* function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
    } */

    function __construct() {
        $this->db = new PDO('mysql:host=sql10.freesqldatabase.com;dbname=sql10695904;charset=utf8', 'sql10695904', 'Mu4pt8x16n');
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