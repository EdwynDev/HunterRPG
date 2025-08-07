<?php
require_once __DIR__ . '/../core/Controller.php';

class CollectionController extends Controller {
    
    public function index() {
        $this->requireLogin();
        
        $currentPlayer = $this->getCurrentPlayer();
        $captureModel = $this->model('Capture');
        
        $captures = $captureModel->getByJoueur($currentPlayer['id']);
        $stats = $captureModel->getStats($currentPlayer['id']);
        
        $this->view('collection/index', [
            'currentPlayer' => $currentPlayer,
            'captures' => $captures,
            'stats' => $stats
        ]);
    }
    
    public function viewCapture($id) {
        $this->requireLogin();
        
        $captureModel = $this->model('Capture');
        $capture = $captureModel->getById($id);
        
        if (!$capture) {
            $this->redirect('collection');
        }
        
        $currentPlayer = $this->getCurrentPlayer();
        
        // Vérifier que la créature appartient au joueur ou est dans un enclos public
        if ($capture['joueur_id'] != $currentPlayer['id'] && !$capture['enclos_id']) {
            $this->redirect('collection');
        }
        
        $this->view('collection/view', [
            'currentPlayer' => $currentPlayer,
            'capture' => $capture
        ]);
    }
}