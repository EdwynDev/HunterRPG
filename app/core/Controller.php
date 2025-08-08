<?php
class Controller {
    public function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    protected function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . ltrim($url, '/'));
        exit;
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['joueur_id']);
    }
    
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }
    
    protected function getCurrentPlayer() {
        if ($this->isLoggedIn()) {
            $joueurModel = $this->model('Joueur');
            return $joueurModel->getById($_SESSION['joueur_id']);
        }
        return null;
    }
}