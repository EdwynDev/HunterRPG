<?php
require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller {
    
    public function index() {
        $currentPlayer = $this->getCurrentPlayer();
        
        // Statistiques générales
        $captureModel = $this->model('Capture');
        $publicEnclos = $captureModel->getPublicEnclos();
        
        $joueurModel = $this->model('Joueur');
        $topPlayers = $joueurModel->getTopPlayers(5);
        
        $creatureModel = $this->model('Creature');
        $creatures = $creatureModel->getAll();
        
        $this->view('home/index', [
            'currentPlayer' => $currentPlayer,
            'publicEnclos' => $publicEnclos,
            'topPlayers' => $topPlayers,
            'creatures' => $creatures
        ]);
    }
}