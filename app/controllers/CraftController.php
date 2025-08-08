<?php
require_once __DIR__ . '/../core/Controller.php';

class CraftController extends Controller {
    
    public function index() {
        $this->requireLogin();
        
        $currentPlayer = $this->getCurrentPlayer();
        $ressourceModel = $this->model('Ressource');
        
        $inventory = $ressourceModel->getPlayerInventory($currentPlayer['id']);
        $recipes = $ressourceModel->getAllRecipes();
        
        // Vérifier quelles recettes peuvent être craftées
        foreach ($recipes as &$recipe) {
            $recipe['can_craft'] = $ressourceModel->canCraftRecipe($currentPlayer['id'], $recipe['id']);
        }
        
        $this->view('craft/index', [
            'currentPlayer' => $currentPlayer,
            'inventory' => $inventory,
            'recipes' => $recipes
        ]);
    }
    
    public function craft($recipeId) {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('craft');
        }
        
        $currentPlayer = $this->getCurrentPlayer();
        $ressourceModel = $this->model('Ressource');
        
        $success = $ressourceModel->craftRecipe($currentPlayer['id'], $recipeId);
        
        if ($success) {
            $_SESSION['craft_success'] = "Objet crafté avec succès !";
        } else {
            $_SESSION['craft_error'] = "Impossible de crafter cet objet. Ressources insuffisantes.";
        }
        
        $this->redirect('craft');
    }
}
?>