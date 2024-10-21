<?php

require_once '../models/User.php';

function validateRegisterForms($formsValues){
    $email = $formsValues['email'];
    $password = $formsValues['password'];
    $username = $formsValues['username'];
    $err = ["username" => false, "email" => false, "password" => false];
    $usernamePattern = "/^[a-zA-Z-' ]*$/";
    $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    unset($_SESSION['register_error']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email";
        $err['email'] = true;
    }
    if (!preg_match($usernamePattern, $username)) {
        $_SESSION['register_error'] = 'Invalid username, only letters and whitespaces allowed';
        $err['username'] = true;
    }
    if(!preg_match($passwordPattern, $password)){
        $_SESSION['register_error'] = 'Invalid password, it should have at least 8 characters, one uppercase letter, one lowercase letter, one number and one special character';
        $err['password'] = true;
    }
    return !($err["email"] || $err['username'] || $err['password']);
}

function validateLoginForms($formsValues){
    $email = $formsValues['email'];
    $err = ["email" => false];
    unset($_SESSION['login_error']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] = "Invalid email";
        $err['email'] = true;
    }
    return !($err["email"]);
}

function getUserByUsernameOrEmail($email, $username){
    return User::getUserByUsernameOrEmail($email, $username);
}

function registerNewUser($email, $password, $username){
    $user = new User($email, $password, $username);
    $userCreation = $user->saveUser();
    if($userCreation){
        return header('Location: /home');
        exit;
    } else {
        return 'error';
    }
}

function verifyPassAndRedirect($userModel, $password, $passwordToCompare){
    $passVerify = $userModel->verifyPassword($password, $passwordToCompare);
    if($passVerify){
        $_SESSION['jwt'] = 'a';
        header('Location: /home');
        exit;
    } else {
        $_SESSION['login_error'] = "Wrong credentials";
        header('Location: /');
        exit;
    }
}

function loginUser($email, $password){
    session_start();
    unset($_SESSION['login_error']);
    $userModel = new User($email, $password);
    $userByEmail = $userModel->getUserByEmail();
    if(!is_array($userByEmail)){
        $userByUsername = $userModel->getUserByUsername($email);
        if(!is_array($userByUsername)){
            $_SESSION['login_error'] = "Wrong credentials";
            header('Location: /');
            exit;
        } else {
            verifyPassAndRedirect($userModel, $password, $userByUsername['password']);
        }
    } else {
        verifyPassAndRedirect($userModel, $password, $userByEmail['password']);
    }
}

function deleteUser($id){
    $adminUser = User::byUserRol('Admin');
    return $adminUser->deleteUser($id);
}

function getUsersList(){
    return User::listUsers();
}



?>