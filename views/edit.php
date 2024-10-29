<?php

require_once '../views/template.php';
require_once '../controllers/editController.php';

if(!isset($user)){
    header('Location: /home');
    exit;
}



?>

<div class="shadow-lg border border-white-500 rounded border-solid flex flex-col justify-center w-3/4 bg-black py-8 px-12">
    <div class="flex flex-row inline-flex">
        <a class="text-white" href="/home">
            <i class="fas text-4xl">&#8592;</i>
        </a>
        <div class="flex flex-row text-center justify-center w-full">
            <h2 class="text-center font-bold text-white mb-5">Edit User</h2>
        </div>
    </div>

    <form class="max-w-sm mx-auto flex flex-col w-3/4 sm:w-full" method="POST" action="../controllers/editController.php">
        <div class="mb-5">
            <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Id<label>
            <input type="text" value=<?= $user->getId() ?> class="disabled bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled="disabled" required />
            <input name="id" type="hidden" id="id" value=<?= $user->getId() ?> class="disabled hidden" required />
        </div>
        <div class="mb-5">
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username<label>
            <input name="username" type="text" id="username" value=<?= $user->getUsername() ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="username example" required />
        </div>
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email<label>
            <input name="email" type="email" id="email" value=<?= $user->getEmail() ?> disabled="disabled" class="disabled bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com" required />
        </div>
        <div class="mb-5">
            <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthdate</label>
            <input name="birthdate" type="date" value=<?= $user->getBirthdate() ?> id="birthdate" max=<?= date('Y-m-d', strtotime("-12 year", time())) ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>
        <span id="passwordError" class="text-red-500 text-xs mb-2"></span>
        <?php if(isset($error)): ?> <span class="text-red-500 text-xs mb-2"><?= $error ?? '' ?></span> <?php endif ?>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
    </form>
</div>
