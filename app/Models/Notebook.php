<?php

    namespace App\Models;

    use App\DB;
    use mysqli;

    class Notebook {
        private mysqli $db;

        public function __construct() {
            $this->db = DB::get();
        }

        public function getAll(): array {
            $result = mysqli_query($this->db, "SELECT * FROM `notebook`");

            if (!$result) return [false, []];

            $notebook = [];
            while($note = mysqli_fetch_assoc($result)) {
                $notebook[] = $note;
            }
            return [true, ['count' => count($notebook), 'list' => $notebook]];
        }

        public function get(int $id): array {
            $result = mysqli_query($this->db, "SELECT * FROM `notebook` WHERE `id` = '$id'");

            if (!$result || mysqli_num_rows($result) === 0) return [false, []];
            return [true, mysqli_fetch_assoc($result)];
        }

        public function add(array $data): array {
            $result = mysqli_query($this->db, "INSERT INTO `notebook` (`id`, `name`, `company`, `phone`, `email`, `birthday`, `photo`) VALUES (NULL, '{$data['name']}', '{$data['company']}', '{$data['phone']}', '{$data['email']}', '{$data['birthday']}', '{$data['photo']}')");

            if (!$result) return [false, []];

            return [true, ['id' => mysqli_insert_id($this->db)]];
        }

        public function update(int $id, array $data): array {
            $result = mysqli_query($this->db, "SELECT * FROM `notebook` WHERE `id` = '$id'");
            if (mysqli_num_rows($result) === 0) return [false, []];

            $result = mysqli_query($this->db, "UPDATE `notebook` SET `name`='{$data['name']}',`company`='{$data['company']}',`phone`='{$data['phone']}',`email`='{$data['email']}',`birthday`='{$data['birthday']}',`photo`='{$data['photo']}' WHERE `id` = '$id'");

            if (!$result) return [false, []];

            return [true, ['id' => $id]];
        }

        public function delete(int $id): array {
            $result = mysqli_query($this->db, "SELECT * FROM `notebook` WHERE `id` = '$id'");
            if (mysqli_num_rows($result) === 0) return [false, []];

            $result = mysqli_query($this->db, "DELETE FROM `notebook` WHERE `notebook`.`id` = '$id'");

            if (!$result) return [false, []];

            return [true, ['id' => $id]];
        }
    }