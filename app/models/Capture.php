<?php
require_once __DIR__ . '/../core/Model.php';

class Capture extends Model {
    
    public function create($joueurId, $creatureId, $statutId, $niveau, $nomPersonnalise = null) {
        $query = "INSERT INTO captures (joueur_id, creature_id, statut_id, niveau, nom_personnalise) 
                  VALUES (?, ?, ?, ?, ?)";
        $this->execute($query, [$joueurId, $creatureId, $statutId, $niveau, $nomPersonnalise]);
        return $this->lastInsertId();
    }
    
    public function getByJoueur($joueurId) {
        $query = "SELECT c.*, cr.nom as creature_nom, cr.rarete, cr.description,
                         s.nom as statut_nom, s.multiplicateur_stats
                  FROM captures c
                  JOIN creatures cr ON c.creature_id = cr.id
                  JOIN statuts_creatures s ON c.statut_id = s.id
                  WHERE c.joueur_id = ?
                  ORDER BY c.date_capture DESC";
        return $this->fetchAll($query, [$joueurId]);
    }
    
    public function getById($id) {
        $query = "SELECT c.*, cr.nom as creature_nom, cr.rarete, cr.description,
                         s.nom as statut_nom, s.multiplicateur_stats,
                         j.pseudo as proprietaire
                  FROM captures c
                  JOIN creatures cr ON c.creature_id = cr.id
                  JOIN statuts_creatures s ON c.statut_id = s.id
                  JOIN joueurs j ON c.joueur_id = j.id
                  WHERE c.id = ?";
        return $this->fetch($query, [$id]);
    }
    
    public function getPublicEnclos() {
        $query = "SELECT c.*, cr.nom as creature_nom, cr.rarete,
                         s.nom as statut_nom, s.multiplicateur_stats,
                         j.pseudo as proprietaire, e.nom as enclos_nom
                  FROM captures c
                  JOIN creatures cr ON c.creature_id = cr.id
                  JOIN statuts_creatures s ON c.statut_id = s.id
                  JOIN joueurs j ON c.joueur_id = j.id
                  JOIN enclos e ON c.enclos_id = e.id
                  WHERE c.enclos_id IS NOT NULL
                  ORDER BY c.date_capture DESC
                  LIMIT 20";
        return $this->fetchAll($query);
    }
    
    public function getStats($joueurId) {
        $query = "SELECT 
                    COUNT(*) as total_captures,
                    COUNT(CASE WHEN cr.rarete = 'legendaire' THEN 1 END) as legendaires,
                    COUNT(CASE WHEN cr.rarete = 'epique' THEN 1 END) as epiques,
                    COUNT(CASE WHEN cr.rarete = 'rare' THEN 1 END) as rares,
                    COUNT(CASE WHEN s.nom = 'Boss' THEN 1 END) as boss_captures
                  FROM captures c
                  JOIN creatures cr ON c.creature_id = cr.id
                  JOIN statuts_creatures s ON c.statut_id = s.id
                  WHERE c.joueur_id = ?";
        return $this->fetch($query, [$joueurId]);
    }
}