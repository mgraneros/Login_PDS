<?php
    session_start();
    $error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : false;
    unset($_SESSION['login_error']);
?>

<div class="lg:w-1/2 sm:w-1/2 lg:flex hidden bg-black h-full">
    <img class="h-full" src="https://cdn.pixabay.com/photo/2024/02/22/05/40/natural-scenery-8589165_640.jpg" />
</div>
<div class="lg:w-1/2 sm:w-3/4 w-full items-center flex flex-col">
    <div class="shadow-lg border border-white-500 rounded border-solid flex flex-col justify-center w-3/4 bg-black py-8 px-12">
        <h2 class="text-center font-bold text-white mb-5">Login</h2>
        

        <form class="max-w-sm mx-auto flex flex-col w-3/4 sm:w-full" method='POST' action="../controllers/loginController.php">
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input name="email" type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com" required />
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input name="password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
            </div>
            <?php if($error): ?> <span class="text-red-500 text-xs mb-2"><?= $error ?? '' ?></span> <?php endif ?>
            <div class="flex items-start mb-5">
                <div class="flex items-center h-5">
                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                </div>
                <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
            <a href="/register" class="text-white text-center font-bold text-xs mt-5 underline">Register</a>
        </form>
    </div>
</div>