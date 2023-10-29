<?php

    namespace App;

    use mysqli;

    abstract class DB {
        public static mysqli $connect;

        static public function connect(): void {
            self::$connect = mysqli_connect(DB_HOST, DB_NAME, DB_PASSWORD, DB_DATABASE);
        }

        static public function get(): mysqli {
            return self::$connect;
        }

    }

