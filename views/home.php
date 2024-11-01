<?php
    require_once '../controllers/userController.php';
    require_once '../controllers/logsController.php';
    require_once '../utils.php';

    session_start();
    if(!isset($_COOKIE['user_id']) && !isset($_SESSION['user_id'])){
        header('Location: /');
        exit;
    } else {
        $me = User::getMe();
        $is_admin_user = isAdmin($me);
    } 
    
    if($is_admin_user){
        $users = getUsersList();
        $logs = getLogs();
    }

    if(isset($users) && is_array($users)){
        $ths = array_keys($users[0]);
    }

    if($is_admin_user && isset($logs) && is_array($logs)){
        $thsLogs = array_keys($logs[0]);
    }

    if($is_admin_user && $_GET && isset($_GET['emailSearch'])){
        $users = getUsersListByEmail($_GET['emailSearch']);
    }

    $containerClassName = $is_admin_user ? 'mt-72 w-full flex flex-col' : 'w-full flex flex-col';
?>
<div class="mt-40 flex flex-column w-full items-center">


    <div class="bg-slate-600 absolute flex flex-row items-center justify-between w-full h-14 top-0">
        <div class="ml-5 text-white font-bold text-xl">Navbar</div>
        <div class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mr-5">
            <form action="/controllers/loginController.php" method="GET">
                <input name="action" value="logout" type="hidden" class="disabled" />
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
    <div class=<?= $containerClassName ?>>
        <div class="w-full flex flex-col items-center">
            <?php if($is_admin_user): ?>
                <div class="flex flex-row justify-between mt-5 w-9/12 items-center">
                    <h1 class="h1 font-bold text-xl">Users lists</h1>
                    <div>
                        <form method="GET" action="#" >
                            <label class="mr-3" for="emailSearch" >Email:</label>
                            <input name="emailSearch" id="emailSearch" class="rounded" type="text" placeholder="Email" value="<?= $_GET['emailSearch'] ?? '' ?>" />
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-full">Search</button>
                        </form>
                    </div>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Add New</button>
                </div>
                <table class="table-auto border mt-3 border-slate-500 w-9/12 [&>tbody>*:nth-child(odd)]:text-white [&>tbody>*:nth-child(even)]:bg-white [&>tbody>*:nth-child(odd)]:bg-gray-600 [&>tbody>*:nth-child(even)]:text-black">
                    <thead>
                <tr class="bg-indigo-600">
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
                    <td class='border border-slate-500'><?= $user['birthdate'] ? formatDateToShow($user['birthdate']) : '' ?></td>
                    <td class='border border-slate-500'><?= $user['deleteDate'] ? formatDateToShow($user['deleteDate']) : '' ?></td>
                    <td class="border border-slate-500"><form method="GET" action="/controllers/editController.php"><input type="hidden" name="idEdit" value=<?= $user['id'] ?> class='disabled' /><button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full">Edit</button></form></td>
                    <td class="border border-slate-500"><form method="POST" action="/controllers/deleteController.php"><input name=<?= $idInputName ?> type="hidden" class="disabled" value=<?= $user['id'] ?> /><button class="<?= $classNames ?>"><?= $buttonText ?></button></form></td>
                </tr>
                <?php endforeach ?>
            </tbody>
            </table>
        </div>


        <div class="w-full flex flex-col items-center my-10">
            <div class="flex flex-row justify-center mt-5 w-9/12 items-center">
                <h1 class="h1 font-bold text-xl">Logs</h1>
            </div>
            <div class="h-72 flex-col flex overflow-y-auto w-9/12">
                <table class="table-auto border mt-3 border-slate-500 w-full [&>tbody>*:nth-child(odd)]:text-white [&>tbody>*:nth-child(even)]:bg-white [&>tbody>*:nth-child(odd)]:bg-gray-600 [&>tbody>*:nth-child(even)]:text-black">
                    <thead>
                    <tr class="bg-indigo-600">
                    <?php foreach($thsLogs as $thLog): ?>
                        <th class="border border-slate-500 capitalize"><?= $thLog ?></th>
                    <?php endforeach ?>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach($logs as $log): ?>
                    <tr class="">
                        <td class='border border-slate-500'><?= $log['id_log'] ?></td>
                        <td class='border border-slate-500'><?= formatLogsDateToShow($log['fecha']) ?></td>
                        <td class='border border-slate-500'><?= $log['usuario_id'] ?></td>
                        <td class='border border-slate-500'><?= $log['accion'] ?></td>
                        <td class='border border-slate-500'><?= $log['descripcion'] ?></td>
                        <td class='border border-slate-500'><?= $log['ip'] ?></td>
                        <td class="border border-slate-500"><?= $log['tabla_afectada'] ?></td>
                    </tr>
                    <?php endforeach ?>
                    </div>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="flex flex-col justify-center items-center">
            <div class="flex flex-row justify-center text-center">
                <span class="mr-2 font-bold">Username: </span>
                <span><?= $me->getUsername() ?></span>
            </div>
            <div class="flex flex-row justify-center text-center mt-2">
                <span class="mr-2 font-bold">Email: </span>
                <span><?= $me->getEmail() ?></span>
            </div>
            <div class="flex flex-row justify-center text-center mt-2">
                <span class="mr-2 font-bold">Id Rol: </span>
                <span><?= $me->getRoleId() ?></span>
            </div>
            <div class="flex flex-row justify-center text-center mt-2">
                <span class="mr-2 font-bold">Fecha Nacimiento: </span>
                <span><?= $me->getBirthdate() ? formatDateToShow($me->getBirthdate()) : '' ?></span>
            </div>
            <div class="flex flex-row justify-center text-center mt-2">
                <form method="GET" action="/controllers/editController.php"><input type="hidden" name="idEdit" value=<?= $me->getId() ?> class='disabled' /><button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full">Edit</button></form>
            </div>
        </div>
    <?php endif ?>
</div>


