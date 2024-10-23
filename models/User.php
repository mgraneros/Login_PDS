<?php 


class User {

    private string $username;
    private string $email;
    private string $password;
    private string $roleId;
    private string $id;

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

    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setId($id){
        $this->id = $id;
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
        $sql = "SELECT email, password, id_rol, id FROM usuarios WHERE email = :email AND es_activo=1";
        $query = $db->db->prepare($sql);
        $query->bindParam('email', $this->getEmail(), PDO::PARAM_STR, 255);
        $query->execute();
        return $query->fetch();
    }

    public function getUserByUsername($username){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT username, password, id_rol, id FROM usuarios WHERE username = :username AND es_activo=1";
        $query = $db->db->prepare($sql);
        $query->bindParam('username', $username, PDO::PARAM_STR, 255);
        $query->execute();
        return $query->fetch();
    }

    public static function getUserByUsernameOrEmail($email, $username){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT id FROM usuarios WHERE email = :email OR username = :username";
        $query = $db->db->prepare($sql);
        $query->bindParam('email', $email, PDO::PARAM_STR, 255);
        $query->bindParam('username', $username, PDO::PARAM_STR, 255);
        $query->execute();
        return $query->fetch();
    }

    public function saveUser(){
        require_once '../db.php';
        $db = new DB();
        $sql = "INSERT INTO usuarios (password, email, username, id_rol, fecha_creacion, es_activo) VALUES (:password, :email, :username, :id_rol, :fecha_creacion, :es_activo)";
        $query = $db->db->prepare($sql);
        $active = 1;
        $query->bindParam('password', $this->getPassword(), PDO::PARAM_STR, 255);
        $query->bindParam('email', $this->getEmail(), PDO::PARAM_STR, 255);
        $query->bindParam('username', $this->getUsername(), PDO::PARAM_STR, 255);
        $query->bindParam('id_rol', $this->getRoleId(), PDO::PARAM_INT, 2);
        $query->bindParam('fecha_creacion', date('Y-m-d'), PDO::PARAM_STR, 10);
        $query->bindParam('es_activo', $active, PDO::PARAM_INT, 1);
        $queryResponse = $query->execute();
        if($queryResponse){
            $id = $db->db->lastInsertId();
        } else {
            $id = false;
        }
        return [ "response" => $queryResponse, 'id' => $id ];
    }

    public static function listUsers(){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT user.id, user.email, user.username, user.fecha_creacion, user.es_activo, roles.nombre_rol AS `role` FROM usuarios user INNER JOIN roles ON user.id_rol = roles.id_rol ORDER BY user.es_activo DESC, user.id_rol";
        $query = $db->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public static function listUsersByEmail($email){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT user.id, user.email, user.username, user.fecha_creacion, user.es_activo, roles.nombre_rol AS `role` FROM usuarios user INNER JOIN roles ON user.id_rol = roles.id_rol WHERE user.email LIKE :email ORDER BY user.es_activo DESC, user.id_rol";
        $query = $db->db->prepare($sql);
        $emailLike = "%$email%";
        $query->bindParam('email', $emailLike, PDO::PARAM_STR, 255);
        $query->execute();
        return $query->fetchAll();
    }

    public function deleteUser($id) {
        require_once '../db.php';
        $db = new DB();
        $sql = "UPDATE usuarios SET es_activo = :es_activo WHERE id = :id";
        $query = $db->db->prepare($sql);
        $active = 0;
        $query->bindParam('es_activo', $active, PDO::PARAM_INT, 1);
        $query->bindParam('id', $id, PDO::PARAM_STR);
        return $query->execute();
    }

    public function restoreUser($id) {
        require_once '../db.php';
        $db = new DB();
        $sql = "UPDATE usuarios SET es_activo = :es_activo WHERE id = :id";
        $query = $db->db->prepare($sql);
        $active = 1;
        $query->bindParam('es_activo', $active, PDO::PARAM_INT, 1);
        $query->bindParam('id', $id, PDO::PARAM_INT);
        return $query->execute();
    }

}

?>