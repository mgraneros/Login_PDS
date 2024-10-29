<?php 

require_once './userController.php';
require_once '../db.php';
session_start();

if($_GET){
    if(isset($_GET['action']) && $_GET['action'] == 'logout'){
        session_destroy();
        setcookie('rol_id', '', -1);
        header('Location: /');
        exit;
    }
}

if($_POST){
    if(validateLoginForms($_POST)){
        $response = loginUser($_POST['email'], $_POST['password'], $_POST['remember']);
    } else {
        DB::insert_log('login_user_error', 'Forms error validation');
        header('Location: /');
        exit;
    }
}



?>