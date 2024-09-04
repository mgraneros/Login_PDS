<?php ?>

<div class="lg:w-1/2 sm:w-1/2 lg:flex hidden bg-black h-full">
    <img class="h-full" src="https://cdn.pixabay.com/photo/2024/02/22/05/40/natural-scenery-8589165_640.jpg" />
</div>
<div class="lg:w-1/2 sm:w-3/4 w-full items-center flex flex-col">
    <div class="shadow-lg border border-white-500 rounded border-solid flex flex-col justify-center w-3/4 bg-black py-8 px-12">
        <h2 class="text-center font-bold text-white mb-5">Login</h2>
        

        <form class="max-w-sm mx-auto flex flex-col w-3/4 sm:w-full">
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@example.com" required />
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
            </div>
            <div class="flex items-start mb-5">
                <div class="flex items-center h-5">
                <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
                </div>
                <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
            <a href="/register" class="text-white text-center font-bold text-xs mt-5">Register</a>
        </form>

        <!-- <form class="flex flex-col justify-center text-center" >
            <label for="name" class="font-xl">Name/Username:</label>
            <input name="name" type="text" />
            <label for="password" class="font-xl">Password:</label>
            <input name="password" type="password" />
        </form> -->
    </div>
</div>