<?php 


class User {

    private string $username;
    private string $email;
    private string $password;
    private string $role;

    public function __construct($username, $email, $password)
    {
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPasswordWithHash($password);
        $this->setRole("normal");
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

    public function getRole(){
        return $this->role;
    }

    public function setRole($role){
        $this->role = $role;
    }

    public static function setAdminRole($email){
        return;
    }

    public function saveUser(){
        require_once '../db.php';
        $db = new DB();
        $sql = 'CALL save_user(?, ?, ?, ?)';
        $query = $db->db->prepare($sql);
        $query->bindParam(1, $this->getUsername(), PDO::PARAM_STR, 60);
    }



}

?>