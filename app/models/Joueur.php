<?php
require_once __DIR__ . '/../core/Model.php';

class Joueur extends Model {
    
    public function create($pseudo, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO joueurs (pseudo, email, mot_de_passe, rang_guilde_id) VALUES (?, ?, ?, 1)";
        $this->execute($query, [$pseudo, $email, $hashedPassword]);
        return $this->lastInsertId();
    }
    
    public function getByEmail($email) {
        $query = "SELECT j.*, g.rang, g.exp_requise 
                  FROM joueurs j 
                  LEFT JOIN guildes g ON j.rang_guilde_id = g.id 
                  WHERE j.email = ?";
        return $this->fetch($query, [$email]);
    }
    
    public function getById($id) {
        $query = "SELECT j.*, g.rang, g.exp_requise 
                  FROM joueurs j 
                  LEFT JOIN guildes g ON j.rang_guilde_id = g.id 
                  WHERE j.id = ?";
        return $this->fetch($query, [$id]);
    }
    
    public function updateExperience($joueurId, $exp) {
        $joueur = $this->getById($joueurId);
        $newExp = $joueur['exp_guilde'] + $exp;
        
        // Vérifier si le joueur peut monter de rang
        $nextRank = $this->getNextRank($joueur['rang_guilde_id'], $newExp);
        
        if ($nextRank) {
            $query = "UPDATE joueurs SET exp_guilde = ?, rang_guilde_id = ? WHERE id = ?";
            $this->execute($query, [$newExp, $nextRank['id'], $joueurId]);
        } else {
            $query = "UPDATE joueurs SET exp_guilde = ? WHERE id = ?";
            $this->execute($query, [$newExp, $joueurId]);
        }
        
        return $nextRank !== null;
    }
    
    public function addGold($joueurId, $amount) {
        $query = "UPDATE joueurs SET ors = ors + ? WHERE id = ?";
        $this->execute($query, [$amount, $joueurId]);
    }
    
    private function getNextRank($currentRankId, $currentExp) {
        $query = "SELECT * FROM guildes WHERE id > ? AND exp_requise <= ? ORDER BY id LIMIT 1";
        return $this->fetch($query, [$currentRankId, $currentExp]);
    }
    
    public function getTopPlayers($limit = 10) {
        $query = "SELECT j.pseudo, j.niveau, j.ors, g.rang, j.exp_guilde,
                         COUNT(c.id) as captures_count
                  FROM joueurs j 
                  LEFT JOIN guildes g ON j.rang_guilde_id = g.id
                  LEFT JOIN captures c ON j.id = c.joueur_id
                  GROUP BY j.id
                  ORDER BY j.rang_guilde_id DESC, j.exp_guilde DESC
                  LIMIT ?";
        return $this->fetchAll($query, [intval($limit)]);
    }
}