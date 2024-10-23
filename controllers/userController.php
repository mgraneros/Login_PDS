<?php

require_once '../models/User.php';

function validateDate($date, $format = 'Y-m-d') { 
	$d = DateTime::createFromFormat($format, $date); 
	return $d && $d->format($format) === $date; 
}

function validateDateBeforeToday($date){
    return strtotime($date) < strtotime('-12 year', time());
}

function validateRegisterForms($formsValues){
    $email = filter_var($formsValues['email'], FILTER_SANITIZE_EMAIL);
    $password = $formsValues['password'];
    $username = $formsValues['username'];
    $birthdate = $formsValues['birthdate'];
    $err = ["username" => false, "email" => false, "password" => false, 'birthdate' => false];
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
    if(!validateDate($birthdate)){
        $_SESSION['register_error'] = 'Invalid format birthdate';
        $err['birthdate'] = true;
    }
    if(!validateDateBeforeToday($birthdate)){
        $_SESSION['register_error'] = 'Invalid birthdate, is before today';
        $err['birthdate'] = true;
    }

    return !($err["email"] || $err['username'] || $err['password'] || $err['birthdate']);
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

function registerNewUser($email, $password, $username, $birthdate){
    $user = new User($email, $password, $username);
    $user->setBirthdate($birthdate);
    $userCreation = $user->saveUser();
    if($userCreation['response']){
        DB::insert_log('register_user_success', 'User registered', $userCreation['id']);
        return header('Location: /home');
        exit;
    } else {
        DB::insert_log('register_user_error', 'Error inserting in DB');
        return 'error';
    }
}

function verifyPassAndRedirect($userModel, $password, $passwordToCompare, $rol_id, $userId, $remember){
    $passVerify = $userModel->verifyPassword($password, $passwordToCompare);
    if($passVerify){
        $_SESSION['jwt'] = 'a';
        $_SESSION['rol_id'] = $rol_id;
        $arr_cookie_options = array (
            'expires' => isset($remember) && $remember ? time() + 60*60*24*30 : time() + 3600,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
            );
        setcookie('rol_id', strval($rol_id), $arr_cookie_options);
        $_SESSION['rol_id'] = $rol_id;
        DB::insert_log('login_user_success', 'Login success', $userId);
        header('Location: /home');
        exit;
    } else {
        DB::insert_log('login_user_error', 'Wrong password', $userId);
        $_SESSION['login_error'] = "Wrong credentials";
        header('Location: /');
        exit;
    }
}

function loginUser($email, $password, $remember){
    session_start();
    unset($_SESSION['login_error']);
    $userModel = new User($email, $password);
    $userByEmail = $userModel->getUserByEmail();
    if(!is_array($userByEmail)){
        $userByUsername = $userModel->getUserByUsername($email);
        if(!is_array($userByUsername)){
            $_SESSION['login_error'] = "Wrong credentials";
            DB::insert_log('login_user_error', 'No user with that email or username');
            header('Location: /');
            exit;
        } else {
            verifyPassAndRedirect($userModel, $password, $userByUsername['password'], $userByUsername['id_rol'], $userByUsername['id'], $remember);
        }
    } else {
        verifyPassAndRedirect($userModel, $password, $userByEmail['password'], $userByEmail['id_rol'], $userByEmail['id'], $remember);
    }
}

function deleteUser($id){
    $adminUser = User::byUserRol('Admin');
    return $adminUser->deleteUser($id);
}

function restoreUser($id){
    $adminUser = User::byUserRol('Admin');
    return $adminUser->restoreUser($id);
}

function getUsersList(){
    return User::listUsers();
}

function getUsersListByEmail($email){
    return User::listUsersByEmail($email);
}


?>