<?php
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/Creature.php';
require_once __DIR__ . '/Capture.php';
require_once __DIR__ . '/Ressource.php';

class Chasse extends Model {
    
    public function generateHunt($joueurId) {
        $joueur = $this->getJoueur($joueurId);
        $creatureModel = new Creature();
        
        // Générer une créature aléatoire
        $creature = $creatureModel->getRandomCreature();
        
        // Générer le niveau de la créature
        $minLevel = max(1, $joueur['niveau'] - 5);
        $maxLevel = $joueur['niveau'] + 5;
        $creatureLevel = rand($minLevel, $maxLevel);
        
        // Générer le statut
        $statutId = $this->generateStatus();
        $statut = $this->getStatutById($statutId);
        
        // Calculer les stats finales
        $finalStats = $this->calculateFinalStats($creature, $creatureLevel, $statut);
        
        return [
            'creature' => $creature,
            'niveau' => $creatureLevel,
            'statut' => $statut,
            'stats' => $finalStats,
            'capture_rate' => $this->calculateCaptureRate($creature, $creatureLevel, $joueur['niveau'])
        ];
    }
    
    public function attemptCapture($joueurId, $creatureData) {
        $captureRate = $creatureData['capture_rate'];
        $success = (mt_rand() / mt_getrandmax()) <= $captureRate;
        
        if ($success) {
            // Créer la capture
            $captureModel = new Capture();
            $captureId = $captureModel->create(
                $joueurId,
                $creatureData['creature']['id'],
                $creatureData['statut']['id'],
                $creatureData['niveau']
            );
            
            // Donner de l'expérience
            $exp = $this->calculateExpReward($creatureData);
            $joueurModel = new Joueur();
            $rankUp = $joueurModel->updateExperience($joueurId, $exp);
            
            return [
                'success' => true,
                'capture_id' => $captureId,
                'exp_gained' => $exp,
                'rank_up' => $rankUp
            ];
        } else {
            // Donner des récompenses de consolation
            $rewards = $this->generateKillRewards($joueurId, $creatureData);
            
            return [
                'success' => false,
                'rewards' => $rewards
            ];
        }
    }
    
    public function generateKillRewards($joueurId, $creatureData) {
        $rewards = ['gold' => 0, 'resources' => []];
        
        // Calculer l'or
        $baseGold = $creatureData['niveau'] * 10;
        $rarityMultiplier = $this->getRarityMultiplier($creatureData['creature']['rarete']);
        $statusMultiplier = $creatureData['statut']['multiplicateur_stats'];
        
        $gold = intval($baseGold * $rarityMultiplier * $statusMultiplier);
        $rewards['gold'] = $gold;
        
        // Donner l'or au joueur
        $joueurModel = new Joueur();
        $joueurModel->addGold($joueurId, $gold);
        
        // Générer les ressources
        $creatureModel = new Creature();
        $creatureWithLoot = $creatureModel->getCreatureWithLoot($creatureData['creature']['id']);
        
        $ressourceModel = new Ressource();
        
        foreach ($creatureWithLoot['loot'] as $loot) {
            if ((mt_rand() / mt_getrandmax()) <= $loot['probabilite']) {
                $rewards['resources'][] = [
                    'nom' => $loot['nom'],
                    'quantite' => 1
                ];
                // Ajouter à l'inventaire du joueur
                $ressourceModel->addToInventory($joueurId, $loot['ressource_id'], 1);
            }
        }
        
        return $rewards;
    }
    
    private function generateStatus() {
        $random = mt_rand() / mt_getrandmax();
        $cumulative = 0;
        
        foreach (STATUS_PROBABILITIES as $statusId => $probability) {
            $cumulative += $probability;
            if ($random <= $cumulative) {
                return $statusId;
            }
        }
        
        return 1; // Normal par défaut
    }
    
    private function calculateCaptureRate($creature, $creatureLevel, $playerLevel) {
        $baseRate = CAPTURE_BASE_RATES[$creature['rarete']];
        $levelDifference = $creatureLevel - $playerLevel;
        $levelModifier = 1 - ($levelDifference * 0.02);
        
        return max(0.01, min(0.95, $baseRate * $levelModifier));
    }
    
    private function calculateExpReward($creatureData) {
        $baseExp = $creatureData['niveau'] * 5;
        $rarityMultiplier = $this->getRarityMultiplier($creatureData['creature']['rarete']);
        $statusMultiplier = $creatureData['statut']['multiplicateur_stats'];
        
        return intval($baseExp * $rarityMultiplier * $statusMultiplier);
    }
    
    private function getRarityMultiplier($rarity) {
        $multipliers = [
            'commun' => 1.0,
            'peu_commun' => 1.5,
            'rare' => 2.0,
            'epique' => 3.0,
            'legendaire' => 5.0
        ];
        
        return $multipliers[$rarity] ?? 1.0;
    }
    
    private function calculateFinalStats($creature, $level, $statut) {
        $baseStats = $level * 10; // Stats de base
        return intval($baseStats * $statut['multiplicateur_stats']);
    }
    
    private function getJoueur($joueurId) {
        $query = "SELECT * FROM joueurs WHERE id = ?";
        return $this->fetch($query, [$joueurId]);
    }
    
    private function getStatutById($id) {
        $query = "SELECT * FROM statuts_creatures WHERE id = ?";
        return $this->fetch($query, [$id]);
    }
}