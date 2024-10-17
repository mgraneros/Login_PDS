<?php
    require_once '../controllers/userController.php';
    $users = getUsersList();
    if(is_array($users)){
        $keys = array_keys($users[0]);
        $ths = array_filter($keys, function ($key){
            return !is_int($key);
        });
    }
    // echo '<pre>'; var_dump($users); echo '<pre>';
?>

<div class="bg-blue-600 absolute flex flex-row items-center justify-center w-full h-10 top-0">
    <div class="flex flex-row items-center justify-center">
        Navbar
    </div>
</div>
<div>
    <table class="table-auto">
    <thead>
        <tr>
        <?php foreach($ths as $th): ?>
            <th><?= $th ?></th>
        <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <tr>
        <?php foreach($users as $user){
            foreach($ths as $key){
                var_dump($user, $key, $user['email']);
                echo `<td>{$user[$key]}</td>`;
            }
        } ?>
        </tr>
    </tbody>
    </table>

</div>