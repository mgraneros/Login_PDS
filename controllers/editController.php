<?php

require_once './userController.php';

if($_GET && isset($_GET['idEdit'])){
    $user = getUserById($_GET['idEdit']);
    require_once '../views/edit.php';
}



?>