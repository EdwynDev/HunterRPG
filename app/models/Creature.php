<?php
require_once __DIR__ . '/../core/Model.php';

class Creature extends Model {
    private $id;
    private $nom;
    private $type;
    private $rarete;
    private $status;
    private $points_vie;
    private $attaque;
    private $defense;
    private $vitesse;
    private $description;
    private $image_url;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getType() { return $this->type; }
    public function getRarete() { return $this->rarete; }
    public function getStatus() { return $this->status; }
    public function getPointsVie() { return $this->points_vie; }
    public function getAttaque() { return $this->attaque; }
    public function getDefense() { return $this->defense; }
    public function getVitesse() { return $this->vitesse; }
    public function getDescription() { return $this->description; }
    public function getImageUrl() { return $this->image_url; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setType($type) { $this->type = $type; }
    public function setRarete($rarete) { $this->rarete = $rarete; }
    public function setStatus($status) { $this->status = $status; }
    public function setPointsVie($points_vie) { $this->points_vie = $points_vie; }
    public function setAttaque($attaque) { $this->attaque = $attaque; }
    public function setDefense($defense) { $this->defense = $defense; }
    public function setVitesse($vitesse) { $this->vitesse = $vitesse; }
    public function setDescription($description) { $this->description = $description; }
    public function setImageUrl($image_url) { $this->image_url = $image_url; }

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
                         GROUP_CONCAT(CONCAT(r.nom, ':', lr.probabilite) SEPARATOR '|') as loot_data
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
                list($name, $probability) = explode(':', $item);
                $result['loot'][] = [
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