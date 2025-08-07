<?php
require_once __DIR__ . '/../core/Controller.php';

class ChasseController extends Controller {
    
    public function index() {
        $this->requireLogin();
        
        $currentPlayer = $this->getCurrentPlayer();
        $captureModel = $this->model('Capture');
        $stats = $captureModel->getStats($currentPlayer['id']);
        
        $this->view('chasse/index', [
            'currentPlayer' => $currentPlayer,
            'stats' => $stats
        ]);
    }
    
    public function hunt() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('chasse');
        }
        
        $currentPlayer = $this->getCurrentPlayer();
        $chasseModel = $this->model('Chasse');
        
        // Générer une chasse
        $huntResult = $chasseModel->generateHunt($currentPlayer['id']);
        
        // Stocker le résultat en session pour la page de résultat
        $_SESSION['current_hunt'] = $huntResult;
        
        $this->view('chasse/encounter', [
            'currentPlayer' => $currentPlayer,
            'huntResult' => $huntResult
        ]);
    }
    
    public function capture() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['current_hunt'])) {
            $this->redirect('chasse');
        }
        
        $currentPlayer = $this->getCurrentPlayer();
        $chasseModel = $this->model('Chasse');
        $huntResult = $_SESSION['current_hunt'];
        
        // Tenter la capture
        $captureResult = $chasseModel->attemptCapture($currentPlayer['id'], $huntResult);
        
        // Nettoyer la session
        unset($_SESSION['current_hunt']);
        
        $this->view('chasse/result', [
            'currentPlayer' => $currentPlayer,
            'huntResult' => $huntResult,
            'captureResult' => $captureResult
        ]);
    }
    
    public function kill() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['current_hunt'])) {
            $this->redirect('chasse');
        }
        
        $currentPlayer = $this->getCurrentPlayer();
        $chasseModel = $this->model('Chasse');
        $huntResult = $_SESSION['current_hunt'];
        
        // Générer les récompenses de kill
        $rewards = $chasseModel->generateKillRewards($currentPlayer['id'], $huntResult);
        
        // Nettoyer la session
        unset($_SESSION['current_hunt']);
        
        $this->view('chasse/kill_result', [
            'currentPlayer' => $currentPlayer,
            'huntResult' => $huntResult,
            'rewards' => $rewards
        ]);
    }
}