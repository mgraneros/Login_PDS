<?php 

require_once './userController.php';
require_once '../db.php';
session_start();


if($_POST){
    if(validateRegisterForms($_POST)){
        $userWithSameUsernameOrEmail = getUserByUsernameOrEmail($_POST['email'], $_POST['username']);
        if(is_array($userWithSameUsernameOrEmail)){
            $_SESSION['register_error'] = "Register failed, choose another username or email";
            DB::insert_log('register_user_error', 'User already exists');
            header('Location: /register');
            exit;
        } else {
            $response = registerNewUser($_POST['email'], $_POST['password'], $_POST['username']);
        }
    } else {
        DB::insert_log('register_user_error', 'Forms validation error');
        header('Location: /register');
        exit;
    }
}



?>