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
        return $this->fetchAll("SELECT * FROM creatures");
    }
    
    public function getRandomCreature() {
        $creatures = $this->getAll();
        if (empty($creatures)) {
            throw new Exception("No creatures found in database");
        }
        
        $totalWeight = 0;
        $weights = [];
        
        foreach ($creatures as $creature) {
            $weight = $this->getRarityWeight($creature['rarete']);
            $weights[] = $weight;
            $totalWeight += $weight;
        }
        
        $random = mt_rand(1, $totalWeight);
        $currentWeight = 0;
        
        foreach ($creatures as $index => $creature) {
            $currentWeight += $weights[$index];
            if ($random <= $currentWeight) {
                return $creature;
            }
        }
        
        return $creatures[0]; // Fallback
    }
    
    private function getRarityWeight($rarete) {
        $weights = [
            'commun' => 500,
            'peu_commun' => 300,
            'rare' => 150,
            'epique' => 40,
            'legendaire' => 10
        ];
        
        return $weights[$rarete] ?? 500;
    }
    
    public function getCreatureWithLoot($id) {
        $creature = $this->fetch("SELECT * FROM creatures WHERE id = ?", [$id]);
        if (!$creature) return null;
        
        $loot = $this->fetchAll(
            "SELECT r.nom, lr.probabilite 
            FROM loot_ressources lr 
            JOIN ressources r ON lr.ressource_id = r.id 
            WHERE lr.creature_id = ?",
            [$id]
        );
        
        $creature['loot'] = $loot;
        return $creature;
    }
}