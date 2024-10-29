<?php 


class User {

    private string $username;
    private string $email;
    private string $password;
    private string $roleId;
    private string $id;
    private string | null $birthdate;
    private string | null $deletionDate;
    private bool $is_active;

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

    public function updateUserByAdmin($id, $username, $birthdate){
        if($this->getRoleId() == 1){
            require_once '../db.php';
            $db = new DB();
            $sql = "UPDATE usuarios SET username = :username, fecha_nacimiento = :birthdate WHERE id = :id";
            $query = $db->db->prepare($sql);
            $query->bindParam('username', $username, PDO::PARAM_STR, 45);
            $query->bindParam('birthdate', $birthdate, PDO::PARAM_STR, 255);
            $query->bindParam('id', $id, PDO::PARAM_INT);
            return $query->execute();
        } else {
            DB::insert_log('update_user_error', 'Unauthorized user');
        }
    }

    public static function byId($id){
        $userObj = new User();
        $user = $userObj->getUserById($id);
        $userObj->setEmail($user['email']);
        $userObj->setBirthdate($user['birthdate']);
        $userObj->setUsername($user['username']);
        $userObj->setId($user['id']);
        $userObj->setRoleId($user['id_rol']);
        $userObj->setDeletionDate($user['deletionDate']);
        $userObj->setIsActive($user['es_activo']);
        return $userObj;
    }
    
    public function getUsername(){
        return $this->username;
    }

    public function getId(){
        return $this->id;
    }

    public function getBirthdate(){
        return $this->birthdate;
    }

    public function getDeletionDate(){
        return $this->deletionDate;
    }

    public function getIsActive(){
        return $this->is_active;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setBirthdate($birthdate){
        $this->birthdate = $birthdate;
    }

    public function setDeletionDate($deletionDate){
        $this->deletionDate = $deletionDate;
    }

    public function setIsActive($is_active){
        $this->is_active = $is_active;
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

    public static function getUserById($id){
        require_once '../db.php';
        $db = new DB();
        $sql = "SELECT id, email, id_rol, fecha_nacimiento AS birthdate, username, es_activo, fecha_eliminacion AS deletionDate FROM usuarios WHERE id = :id";
        $query = $db->db->prepare($sql);
        $query->bindParam('id', $id, PDO::PARAM_INT, 11);
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
        $sql = "INSERT INTO usuarios (password, email, username, id_rol, fecha_creacion, es_activo, fecha_nacimiento) VALUES (:password, :email, :username, :id_rol, :fecha_creacion, :es_activo, :birthdate)";
        $query = $db->db->prepare($sql);
        $active = 1;
        $query->bindParam('password', $this->getPassword(), PDO::PARAM_STR, 255);
        $query->bindParam('email', $this->getEmail(), PDO::PARAM_STR, 255);
        $query->bindParam('username', $this->getUsername(), PDO::PARAM_STR, 255);
        $query->bindParam('id_rol', $this->getRoleId(), PDO::PARAM_INT, 2);
        $query->bindParam('fecha_creacion', date('Y-m-d'), PDO::PARAM_STR, 10);
        $query->bindParam('es_activo', $active, PDO::PARAM_INT, 1);
        $query->bindParam('birthdate', $this->getBirthdate(), PDO::PARAM_STR, 10);
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
        $sql = "SELECT user.id, user.email, user.username, user.fecha_creacion, user.es_activo, roles.nombre_rol AS `role`, user.fecha_nacimiento AS birthdate, user.fecha_eliminacion AS deleteDate FROM usuarios user INNER JOIN roles ON user.id_rol = roles.id_rol ORDER BY user.es_activo DESC, user.id_rol";
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
        if($this->getRoleId() == 1){

            require_once '../db.php';
            $db = new DB();
            $sql = "UPDATE usuarios SET es_activo = :es_activo, fecha_eliminacion = :fecha_elim WHERE id = :id";
            $query = $db->db->prepare($sql);
            $active = 0;
            $deleteDate = date('Y-m-d');
            $query->bindParam('es_activo', $active, PDO::PARAM_INT, 1);
            $query->bindParam('id', $id, PDO::PARAM_STR);
            $query->bindParam('fecha_elim', $deleteDate, PDO::PARAM_STR, 10);
            return $query->execute();
        } else {
            DB::insert_log('delete_user_error', 'Unauthorized user');
        }
    }

    public function restoreUser($id) {
        if($this->getRoleId() == 1){

            require_once '../db.php';
            $db = new DB();
            $sql = "UPDATE usuarios SET es_activo = :es_activo WHERE id = :id";
            $query = $db->db->prepare($sql);
            $active = 1;
            $query->bindParam('es_activo', $active, PDO::PARAM_INT, 1);
            $query->bindParam('id', $id, PDO::PARAM_INT);
            return $query->execute();
        } else {
            DB::insert_log('restore_user_error', 'Unauthorized user');
        }
    }

    public static function getMe(){
        return User::byId($_COOKIE['user_id']);
    }

}

?>