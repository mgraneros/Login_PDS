<?php
    require_once '../controllers/userController.php';
    require_once '../controllers/logsController.php';
    require_once '../utils.php';

    session_start();
    if(!isset($_COOKIE['rol_id']) && !isset($_SESSION['rol_id'])){
        header('Location: /');
        exit;
    } elseif (isset($_COOKIE['rol_id']) && $_COOKIE['rol_id'] === 1 || $_SESSION['rol_id'] === 1) {
        $is_admin_user = True;
    } else {
        $is_admin_user = False;
    }
    if($is_admin_user){
        $users = getUsersList();
        $logs = getLogs();
        // echo '<pre>'; var_dump($logs); echo '<pre>';exit;
    } else {
        //TODO Change this to a "find myself" function
        $users = getUsersList();
    }
    if(is_array($users)){
        $ths = array_keys($users[0]);
    }
    if(is_array($logs)){
        $thsLogs = array_keys($logs[0]);
    }
    // echo '<pre>'; var_dump('users: ', $users); echo '<pre>';
?>

<div class="bg-blue-600 absolute flex flex-row items-center justify-center w-full h-10 top-0">
    <div class="flex flex-row items-center justify-center">
        Navbar
    </div>
</div>
<div class="w-full flex flex-col">
    <div class="w-full flex flex-col items-center">
        <div class="flex flex-row justify-between mt-5 w-9/12 items-center">
            <h1 class="h1 font-bold text-xl">Users lists</h1>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Add New</button>
        </div>
        <table class="table-auto border mt-3 border-slate-500 w-9/12 [&>tbody>*:nth-child(odd)]:text-white [&>tbody>*:nth-child(even)]:bg-white [&>tbody>*:nth-child(odd)]:bg-gray-600 [&>tbody>*:nth-child(even)]:text-black">
        <thead>
            <tr>
            <?php foreach($ths as $th): ?>
                <th class="border border-slate-500 capitalize"><?= $th ?></th>
            <?php endforeach ?>
                <th class='border border-slate-500 capitalize' colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach($users as $user): 
                $idInputName = $user['es_activo'] ? 'idToDelete' : 'idToRestore';
                $classNames = $user['es_activo'] ? "bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full" : "bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full";
                $buttonText = $user['es_activo'] ? 'Delete' : 'Restore';

                ?>
            <tr>
                <td class='border border-slate-500'><?= $user['id'] ?></td>
                <td class='border border-slate-500'><?= $user['email'] ?></td>
                <td class='border border-slate-500'><?= $user['username'] ?></td>
                <td class='border border-slate-500'><?= formatDateToShow($user['fecha_creacion']) ?></td>
                <td class='border border-slate-500'><?= $user['es_activo'] ?></td>
                <td class='border border-slate-500'><?= $user['role'] ?></td>
                <td class="border border-slate-500"><button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full">Edit</button></td>
                <td class="border border-slate-500"><form method="POST" action="/controllers/deleteController.php"><input name=<?= $idInputName ?> type="hidden" value=<?= $user['id'] ?> /><button class="<?= $classNames ?>"><?= $buttonText ?></button></form></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        </table>

    </div>
    <div class="w-full flex flex-col items-center my-10">
        <table class="table-auto border mt-3 border-slate-500 w-9/12 [&>tbody>*:nth-child(odd)]:text-white [&>tbody>*:nth-child(even)]:bg-white [&>tbody>*:nth-child(odd)]:bg-gray-600 [&>tbody>*:nth-child(even)]:text-black">
        <thead>
            <tr>
            <?php foreach($thsLogs as $thLog): ?>
                <th class="border border-slate-500 capitalize"><?= $thLog ?></th>
            <?php endforeach ?>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach($logs as $log): ?>
            <tr>
                <td class='border border-slate-500'><?= $log['id_log'] ?></td>
                <td class='border border-slate-500'><?= formatDateToShow($log['fecha']) ?></td>
                <td class='border border-slate-500'><?= $log['usuario_id'] ?></td>
                <td class='border border-slate-500'><?= $log['accion'] ?></td>
                <td class='border border-slate-500'><?= $log['descripcion'] ?></td>
                <td class='border border-slate-500'><?= $log['ip'] ?></td>
                <td class="border border-slate-500"><?= $log['tabla_afectada'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        </table>

    </div>
</div>


