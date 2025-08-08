<?php
require_once __DIR__ . '/../core/Model.php';

class Ressource extends Model {
    
    public function getAll() {
        $query = "SELECT * FROM ressources ORDER BY nom";
        return $this->fetchAll($query);
    }
    
    public function getById($id) {
        $query = "SELECT * FROM ressources WHERE id = ?";
        return $this->fetch($query, [$id]);
    }
    
    public function getPlayerInventory($joueurId) {
        $query = "SELECT r.*, ir.quantite 
                  FROM ressources r
                  LEFT JOIN inventaire_ressources ir ON r.id = ir.ressource_id AND ir.joueur_id = ?
                  ORDER BY r.nom";
        $results = $this->fetchAll($query, [$joueurId]);
        
        // Assurer que la quantité est 0 si pas d'entrée dans l'inventaire
        foreach ($results as &$result) {
            $result['quantite'] = $result['quantite'] ?? 0;
        }
        
        return $results;
    }
    
    public function addToInventory($joueurId, $ressourceId, $quantite) {
        // Vérifier si l'entrée existe déjà
        $existing = $this->fetch(
            "SELECT * FROM inventaire_ressources WHERE joueur_id = ? AND ressource_id = ?",
            [$joueurId, $ressourceId]
        );
        
        if ($existing) {
            // Mettre à jour la quantité existante
            $query = "UPDATE inventaire_ressources SET quantite = quantite + ? WHERE joueur_id = ? AND ressource_id = ?";
            $this->execute($query, [$quantite, $joueurId, $ressourceId]);
        } else {
            // Créer une nouvelle entrée
            $query = "INSERT INTO inventaire_ressources (joueur_id, ressource_id, quantite) VALUES (?, ?, ?)";
            $this->execute($query, [$joueurId, $ressourceId, $quantite]);
        }
    }
    
    public function removeFromInventory($joueurId, $ressourceId, $quantite) {
        $query = "UPDATE inventaire_ressources 
                  SET quantite = GREATEST(0, quantite - ?) 
                  WHERE joueur_id = ? AND ressource_id = ?";
        $this->execute($query, [$quantite, $joueurId, $ressourceId]);
    }
    
    public function getPlayerResourceQuantity($joueurId, $ressourceId) {
        $query = "SELECT quantite FROM inventaire_ressources WHERE joueur_id = ? AND ressource_id = ?";
        $result = $this->fetch($query, [$joueurId, $ressourceId]);
        return $result ? $result['quantite'] : 0;
    }
    
    public function getAllRecipes() {
        $query = "SELECT r.*, 
                         GROUP_CONCAT(CONCAT(res.nom, ':', rr.quantite) SEPARATOR '|') as ingredients
                  FROM recettes r
                  LEFT JOIN recette_ressources rr ON r.id = rr.recette_id
                  LEFT JOIN ressources res ON rr.ressource_id = res.id
                  GROUP BY r.id
                  ORDER BY r.nom";
        
        $results = $this->fetchAll($query);
        
        // Parser les ingrédients
        foreach ($results as &$recipe) {
            $recipe['ingredients_parsed'] = [];
            if ($recipe['ingredients']) {
                $ingredients = explode('|', $recipe['ingredients']);
                foreach ($ingredients as $ingredient) {
                    list($name, $quantity) = explode(':', $ingredient);
                    $recipe['ingredients_parsed'][] = [
                        'nom' => $name,
                        'quantite' => intval($quantity)
                    ];
                }
            }
        }
        
        return $results;
    }
    
    public function getRecipeById($id) {
        $query = "SELECT r.*, 
                         GROUP_CONCAT(CONCAT(res.id, ':', res.nom, ':', rr.quantite) SEPARATOR '|') as ingredients
                  FROM recettes r
                  LEFT JOIN recette_ressources rr ON r.id = rr.recette_id
                  LEFT JOIN ressources res ON rr.ressource_id = res.id
                  WHERE r.id = ?
                  GROUP BY r.id";
        
        $result = $this->fetch($query, [$id]);
        
        if ($result) {
            $result['ingredients_parsed'] = [];
            if ($result['ingredients']) {
                $ingredients = explode('|', $result['ingredients']);
                foreach ($ingredients as $ingredient) {
                    list($ressourceId, $name, $quantity) = explode(':', $ingredient);
                    $result['ingredients_parsed'][] = [
                        'id' => intval($ressourceId),
                        'nom' => $name,
                        'quantite' => intval($quantity)
                    ];
                }
            }
        }
        
        return $result;
    }
    
    public function canCraftRecipe($joueurId, $recipeId) {
        $recipe = $this->getRecipeById($recipeId);
        if (!$recipe) return false;
        
        foreach ($recipe['ingredients_parsed'] as $ingredient) {
            $playerQuantity = $this->getPlayerResourceQuantity($joueurId, $ingredient['id']);
            if ($playerQuantity < $ingredient['quantite']) {
                return false;
            }
        }
        
        return true;
    }
    
    public function craftRecipe($joueurId, $recipeId) {
        if (!$this->canCraftRecipe($joueurId, $recipeId)) {
            return false;
        }
        
        $recipe = $this->getRecipeById($recipeId);
        
        // Consommer les ressources
        foreach ($recipe['ingredients_parsed'] as $ingredient) {
            $this->removeFromInventory($joueurId, $ingredient['id'], $ingredient['quantite']);
        }
        
        // TODO: Ajouter l'objet crafté à l'inventaire du joueur
        // Pour l'instant, on donne juste de l'or comme récompense
        $joueurModel = new Joueur();
        $goldReward = 100; // Récompense de base
        $joueurModel->addGold($joueurId, $goldReward);
        
        return true;
    }
}
?>