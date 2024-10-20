<?php
    require_once '../controllers/userController.php';
    $users = getUsersList();
    if(is_array($users)){
        $ths = array_keys($users[0]);
    }
    // echo '<pre>'; var_dump('users: ', $users); echo '<pre>';
?>

<!-- <div class="bg-blue-600 absolute flex flex-row items-center justify-center w-full h-10 top-0">
    <div class="flex flex-row items-center justify-center">
        Navbar
    </div>
</div> -->
<div>
    <table class="table-auto border-spacing-2 border-separate border border-slate-500">
    <thead>
        <tr>
        <?php foreach($ths as $th): ?>
            <th><?= $th ?></th>
        <?php endforeach ?>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php foreach($users as $user): ?>
        <tr>
            <?php foreach($ths as $key){
                // echo '<pre>'; var_dump($user, $key, $user['email']); echo '<pre>';
                echo "<td>" . $user[$key] . "</td>";
            } 
            ?>
            <td class="btn"><button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full">Edit</button></td>
            <td class="btn"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Update</button></td>
        </tr>
        <?php endforeach ?>
    </tbody>
    </table>

</div>