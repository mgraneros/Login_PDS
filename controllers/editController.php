<?php

require_once './userController.php';
require_once '../db.php';
session_start();

if($_GET && isset($_GET['idEdit'])){
    $user = getUserById($_GET['idEdit']);
    $title = "Edit User";
    require_once '../views/edit.php';
}

if(isset($_POST) && $_POST){
    if(validateEditForms($_POST)){
        $update = updateUserByAdmin($_POST['id'], $_POST['username'], $_POST['birthdate']);
        if($update){
            $_SESSION['userUpdate'] = true;
            DB::insert_log('update_user_success', "User updated");
        } else {
            DB::insert_log('update_user_error', 'Problem updating user');
        }
        header('Location: /home');
        exit;
    } else {
        DB::insert_log('update_user_error', 'Forms error validation');
        header('Location: /home');
        exit;
    }

}



?>