<?php 

require_once './userController.php';
session_start();


if($_POST){
    if(validateRegisterForms($_POST)){
        $userWithSameUsernameOrEmail = getUserByUsernameOrEmail($_POST['email'], $_POST['username']);
        if(is_array($userWithSameUsernameOrEmail)){
            $_SESSION['register_error'] = "Register failed, choose another username or email";
            header('Location: /register');
            exit;
        } else {
            $response = registerNewUser($_POST['email'], $_POST['password'], $_POST['username']);
            unset($_SESSION['register_error']);
        }
    } else {
        header('Location: /register');
        exit;
    }
}



?>