<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class UserModel {
    private $db;
    private $dotenv;

    function __construct() {
        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $this->dotenv->safeLoad();

        $this->db = new PDO('mysql:host=' . $_ENV["DB_HOSTNAME"] . ';port=' . $_ENV["DB_PORT"] . ';dbname=' . $_ENV["DB_NAME"] . ';charset=utf8', $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
    }

    public function findAllUsers() {
        $query = $this->db->prepare("SELECT u.*, r.name AS role FROM user u JOIN role r ON u.role_id = r.id");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAllUsersByRole($role) {
        $query = $this->db->prepare("SELECT u.*, r.name AS role 
        FROM user u
        JOIN role r ON u.role_id = r.id
        WHERE r.name = ?");
        $query->execute([$role]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findUserById($id) {
        $query = $this->db->prepare("SELECT u.*, r.name AS role FROM user u JOIN role r ON u.role_id = r.id WHERE u.id = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function findAllUsersByFilter($filter, $roles) {
        // Return a string with tokens (?) separated with commas depending on the $roles array length
        $in = implode(',', array_fill(0, count($roles), '?'));

        $query = $this->db->prepare("SELECT u.*, r.name AS role 
        FROM user u 
        JOIN role r ON u.role_id = r.id 
        WHERE (u.username LIKE CONCAT(?, '%') OR u.email LIKE CONCAT(?, '%'))
        AND r.name IN ($in)
        ORDER BY r.name, u.username");
        $query->execute(array_merge([$filter, $filter], $roles));

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Retrieves USER type users
    public function findAllUsersByUsername($filter) {
        $query = $this->db->prepare("SELECT u.*, r.name AS role
        FROM user u
        JOIN role r ON u.role_id = r.id
        WHERE u.username LIKE CONCAT(?, '%')
        OR u.email LIKE CONCAT(?, '%')
        AND r.name = 'USER'");
        $query->execute([$filter, $filter]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findUserByEmail($email) {
        $query = $this->db->prepare("SELECT u.*, r.name AS role FROM user u JOIN role r ON u.role_id = r.id WHERE email = ?");
        $query->execute([$email]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function saveUser($username, $email, $password, $role) {
        $query = $this->db->prepare("INSERT INTO user(username, email, password, role_id) VALUES(?,?,?,?)");
        $query->execute([$username, $email, $password, $role]);

        return $this->db->lastInsertId();
    }

    public function updateProfileInformation($email, $username, $userId) {
        $query = $this->db->prepare("UPDATE user SET email = ?, username = ? WHERE id = ?");
        $query->execute([$email, $username, $userId]);
    }

    public function updateProfileImage($image, $userId) {
        $query = $this->db->prepare("UPDATE user SET image = ? WHERE id = ?");
        $query->execute([$image, $userId]);
    }

    public function updateUserPassword($hashedPassword, $userId) {
        $query = $this->db->prepare("UPDATE user SET password = ? WHERE id = ?");
        $query->execute([$hashedPassword, $userId]);
    }

    public function updateUserRole($roleId, $userId) {
        $query = $this->db->prepare("UPDATE user SET role_id = ? WHERE id = ?");
        $query->execute([$roleId, $userId]);
    }
}
?>