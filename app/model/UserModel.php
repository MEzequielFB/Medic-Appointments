<?php
class UserModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=appointments_db;charset=utf8', 'root', '');
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
        /* $in = str_repeat('?,', count($roles) - 1) . '?'; */
        $in = implode(',', array_fill(0, count($roles), '?'));

        $query = $this->db->prepare("SELECT u.*, r.name AS role 
        FROM user u 
        JOIN role r ON u.role_id = r.id 
        WHERE (u.username = ? OR u.email = ?)
        OR r.name IN ($in)");
        $query->execute(array_merge([$filter, $filter], $roles));

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