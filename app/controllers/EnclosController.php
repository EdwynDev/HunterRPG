<?php
require_once __DIR__ . '/../core/Controller.php';

class EnclosController extends Controller {
    
    public function index() {
        $captureModel = $this->model('Capture');
        $publicEnclos = $captureModel->getPublicEnclos();
        
        $currentPlayer = $this->getCurrentPlayer();
        
        $this->view('enclos/index', [
            'currentPlayer' => $currentPlayer,
            'publicEnclos' => $publicEnclos
        ]);
    }
}