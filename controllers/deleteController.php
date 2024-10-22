<?php

require_once './userController.php';
require_once '../db.php';
session_start();

if($_POST && isset($_POST['idToDelete'])){
    // TODO validate also if actual user is admin
    $userDeletion = deleteUser($_POST['idToDelete']);
    if($userDeletion){
        $_SESSION['userDeletion'] = true;
        DB::insert_log('delete_user_success', "User delete");
        header('Location: /home');
        exit;
    } else {
        DB::insert_log('delete_user_error', 'Problem deleting user');
    }
}


if($_POST && isset($_POST['idToRestore'])){
    // TODO validate also if actual user is admin
    $userRestoration = restoreUser($_POST['idToRestore']);
    if($userRestoration){
        $_SESSION['userRestoration'] = true;
        DB::insert_log('restore_user_success', "User restored");
        header('Location: /home');
        exit;
    } else {
        DB::insert_log('restore_user_error', 'Problem restoring user');
    }
}

?>