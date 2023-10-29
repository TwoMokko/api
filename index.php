<?php

    const ROOT_DIR = __DIR__ . '/';

    require ROOT_DIR . 'settings.php';
    require ROOT_DIR . 'app/DB.php';
    require ROOT_DIR . 'app/Route.php';

    App\DB::connect();
    App\Route::run();