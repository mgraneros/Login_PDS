<?php

require_once './userController.php';
session_start();

if($_POST && isset($_POST['idToDelete'])){
    // TODO validate also if actual user is admin
    $userDeletion = deleteUser($_POST['idToDelete']);
    if($userDeletion){
        $_SESSION['userDeletion'] = true;
        header('Location: /home');
        exit;
    }
}

?>