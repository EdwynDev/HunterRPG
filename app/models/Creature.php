<?php
require_once __DIR__ . '/../core/Model.php';

class Creature extends Model {
    
    public function getAll() {
        $query = "SELECT * FROM creatures ORDER BY 
                  CASE rarete 
                    WHEN 'commun' THEN 1
                    WHEN 'peu_commun' THEN 2
                    WHEN 'rare' THEN 3
                    WHEN 'epique' THEN 4
                    WHEN 'legendaire' THEN 5
                  END, nom";
        return $this->fetchAll($query);
    }
    
    public function getById($id) {
        $query = "SELECT * FROM creatures WHERE id = ?";
        return $this->fetch($query, [$id]);
    }
    
    public function getRandomCreature() {
        $creatures = $this->getAll();
        $totalWeight = 0;
        $weightedCreatures = [];
        
        foreach ($creatures as $creature) {
            $weight = RARITY_PROBABILITIES[$creature['rarete']];
            $totalWeight += $weight;
            $weightedCreatures[] = [
                'creature' => $creature,
                'weight' => $totalWeight
            ];
        }
        
        $random = mt_rand() / mt_getrandmax() * $totalWeight;
        
        foreach ($weightedCreatures as $weighted) {
            if ($random <= $weighted['weight']) {
                return $weighted['creature'];
            }
        }
        
        return $creatures[0]; // Fallback
    }
    
    public function getCreatureWithLoot($creatureId) {
        $query = "SELECT c.*, 
                         GROUP_CONCAT(CONCAT(r.id, ':', r.nom, ':', lr.probabilite) SEPARATOR '|') as loot_data
                  FROM creatures c
                  LEFT JOIN loot_ressources lr ON c.id = lr.creature_id
                  LEFT JOIN ressources r ON lr.ressource_id = r.id
                  WHERE c.id = ?
                  GROUP BY c.id";
        
        $result = $this->fetch($query, [$creatureId]);
        
        if ($result && $result['loot_data']) {
            $lootItems = explode('|', $result['loot_data']);
            $result['loot'] = [];
            
            foreach ($lootItems as $item) {
                list($ressourceId, $name, $probability) = explode(':', $item);
                $result['loot'][] = [
                    'ressource_id' => intval($ressourceId),
                    'nom' => $name,
                    'probabilite' => floatval($probability)
                ];
            }
        } else {
            $result['loot'] = [];
        }
        
        return $result;
    }
}