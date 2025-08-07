<?php
class Controller {
    public function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    public function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }

    public function requireLogin() {
        if (!isset($_SESSION['player_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function getCurrentPlayer() {
        if (isset($_SESSION['player_id'])) {
            $playerModel = $this->model('Player');
            return $playerModel->getById($_SESSION['player_id']);
        }
        return null;
    }

    public function redirect($path) {
        header('Location: /' . $path);
        exit;
    }
}