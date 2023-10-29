<?php

    namespace App\Controllers;

    require ROOT_DIR . 'App/Models/Notebook.php';

    use App\Models;
    use App\Response;

    class Notebook {

        public function __construct(string $method, int $id) {
            $modelNotebook = new Models\Notebook();
            switch ($method) {
                case 'GET':
                    [$state, $result] = ($id) ? $modelNotebook->get($id) : $modelNotebook->getAll();
                    $state ? Response::sendOK($result) : Response::sendError(Response::ERROR_NOT_FOUND, 'Not found');
                    break;
                case 'POST':
                    $data = $this->prepareData($_POST);
                    if (!$this->validation($data)) Response::sendError(Response::ERROR_VALIDATION,'Unprocessable Entity');

                    [$state, $result] = ($id) ? $modelNotebook->update($id, $data) : $modelNotebook->add($data);
                    $state ? Response::sendOK($result) : Response::sendError(Response::ERROR_REQUEST, 'Bad Request');
                    break;
                case 'DELETE':
                    [$state, $result] = $modelNotebook->delete($id);
                    $state ? Response::sendOK($result) : Response::sendError(Response::ERROR_REQUEST, 'Bad Request');
                    break;
                default: Response::sendError(Response::ERROR_REQUEST, 'Bad Request');
            }
        }

        private function validation(array $data): bool {
            if ($data['name'] === '') return false;
            if ($data['phone'] === '') return false;
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) return false;

            return true;
        }

        private function prepareData(array $data): array {
            $out = [];
            $out['name'] = $data['name'] ?? '';
            $out['company'] = $data['company'] ?? '';
            $out['phone'] = $data['phone'] ?? '';
            $out['email'] = $data['email'] ?? '';
            $out['birthday'] = $data['birthday'] ?? '';
            $out['photo'] = $data['photo'] ?? '';
            return $out;
        }
    }