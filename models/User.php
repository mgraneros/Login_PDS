<?php 


class User {

    private string $username;
    private string $email;
    private string $password;
    private string $roleId;

    public function __construct($email = '', $password = '', $username = "")
    {
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPasswordWithHash($password);
        $this->setRoleId(2);
    }

    public static function byUserRol($rol){
        $user = new self();
        $user->setRoleId($rol);
        return $user;
    }

    
    public function getUsername(){
        return $this->username;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setPasswordWithHash($password){
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPassword(){
        return $this->password;
    }

    public function verifyPassword($notHashPassword, $hashedPassword){
        return password_verify($notHashPassword, $hashedPassword);
    }

    public function getRoleId(){
        return $this->roleId;
    }

    public function setRoleId($roleId){
        $this->roleId = $roleId;
    }

    public static function setAdminRole($email){
        return;
    }

    public function getUserByEmail(){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT email, password, id_rol FROM usuarios WHERE email = ? AND es_activo=1";
        $query = $db->db->prepare($sql);
        $query->execute([$this->getEmail()]);
        return $query->fetch();
    }

    public function getUserByUsername($username){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT username, password, id_rol FROM usuarios WHERE username = ? AND es_activo=1";
        $query = $db->db->prepare($sql);
        $query->execute([$username]);
        return $query->fetch();
    }

    public static function getUserByUsernameOrEmail($email, $username){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT id FROM usuarios WHERE email = ? OR username = ?";
        $query = $db->db->prepare($sql);
        $query->execute([$email, $username]);
        return $query->fetch();
    }

    public function saveUser(){
        require_once '../db.php';
        $db = new DB();
        $sql = "INSERT INTO usuarios (password, email, username, id_rol, fecha_creacion, es_activo) VALUES (?, ?, ?, ?, ?, ?)";
        $query = $db->db->prepare($sql);
        $queryResponse = $query->execute([$this->getPassword(), $this->getEmail(), $this->getUsername(), $this->getRoleId(), date('Y-m-d'), 1]);
        return $queryResponse;
    }

    public static function listUsers(){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT user.id, user.email, user.username, user.fecha_creacion, user.es_activo, roles.nombre_rol AS `role` FROM usuarios user INNER JOIN roles ON user.id_rol = roles.id_rol ORDER BY user.es_activo DESC, user.id_rol";
        $query = $db->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function deleteUser($id) {
        require_once '../db.php';
        $db = new DB();
        $sql = "UPDATE usuarios SET es_activo=0 WHERE id = ?";
        $query = $db->db->prepare($sql);
        return $query->execute([$id]);
    }

    public function restoreUser($id) {
        require_once '../db.php';
        $db = new DB();
        $sql = "UPDATE usuarios SET es_activo=1 WHERE id = ?";
        $query = $db->db->prepare($sql);
        return $query->execute([$id]);
    }

}

?>