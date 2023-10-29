<?php

    namespace App;

    require ROOT_DIR . 'App/Controllers/Notebook.php';
    require ROOT_DIR . 'App/Response.php';

    abstract class Route {
        private static ?string $method = null;
        private static ?string $version = null;
        private static ?string $controller = null;
        private static int $id = 0;

        static function run(): void {
            self::$method = $_SERVER['REQUEST_METHOD'];
            $url = $_SERVER['REQUEST_URI'];
            $params = explode('/', $url);

            if (isset($params[1])) self::$version = $params[1];
            if (isset($params[2])) self::$controller = $params[2];
            if (isset($params[3])) self::$id = (int)$params[3];

            if (self::$version !== VERSION_API) Response::sendError( Response::ERROR_VALIDATION,'api version error');

            switch (self::$controller) {
                case 'notebook': new Controllers\Notebook(self::$method, self::$id); break;
                default: Response::sendError(Response::ERROR_REQUEST, 'Bad Request');
            }
        }
    }