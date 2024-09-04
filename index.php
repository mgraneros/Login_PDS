<?php
    require_once './db.php';

    $db = new DB();

    $title = "Login";
    require_once './views/template.php';

    require_once './views/login.php';

    require_once './views/footer.php';
?>
