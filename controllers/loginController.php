<?php 

require_once './userController.php';
require_once '../db.php';
session_start();


if($_POST){
    if(validateLoginForms($_POST)){
        $response = loginUser($_POST['email'], $_POST['password']);
    } else {
        DB::insert_log('login_user_error', 'Forms error validation');
        header('Location: /');
        exit;
    }
}



?>