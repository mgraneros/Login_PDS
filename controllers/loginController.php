<?php 

require_once './userController.php';
session_start();


if($_POST){
    if(validateLoginForms($_POST)){
        $response = loginUser($_POST['email'], $_POST['password']);
    } else {
        header('Location: /');
        exit;
    }
}



?>