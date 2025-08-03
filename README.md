Parfait, voici un **fichier knowledge complet** et structuré pour ton application web de chasse et collection de monstres. Il est rédigé pour servir de base technique et fonctionnelle au développement.

---

## 📂 Knowledge – Application Web de Chasse aux Monstres

### 1. Présentation générale

Une application web RPG où les joueurs peuvent partir en chasse pour rencontrer, capturer, collectionner et faire évoluer des créatures.
Le système repose sur :

* Une mécanique de **chasses aléatoires**.
* Un système de **rareté et statut** des créatures.
* Des **probabilités de capture** influencées par divers éléments.
* Une **progression via une guilde d’aventuriers**.
* La **collecte de ressources** pour l’artisanat.
* Un système de **gestion et reproduction de créatures**.

---

## 2. Système de chasse

### 2.1. Déroulement d’une chasse

1. Le joueur lance une chasse.
2. Le système tire au sort une créature en fonction de sa zone (ou pool global si zone unique).
3. La créature obtient :

   * **Niveau** : aléatoire dans la fourchette `[niveau_joueur - 5, niveau_joueur + 5]` (avec minimum 1).
   * **Statut** : Normal, Élite, Alpha ou Boss selon une table de probabilités.
4. Le joueur peut :

   * **Tenter de capturer** la créature.
   * **L’éliminer** pour récupérer de l’or et des ressources.

### 2.2. Statuts des créatures

| Statut | Bonus Stats | Probabilité par défaut |
| ------ | ----------- | ---------------------- |
| Normal | x1          | 70 %                   |
| Élite  | x1.2        | 20 %                   |
| Alpha  | x1.5        | 9 %                    |
| Boss   | x2          | 1 %                    |

---

## 3. Rareté des créatures

Chaque créature appartient à une rareté qui influe sur sa valeur, sa probabilité de capture et ses chances d’apparaître.

| Rareté     | Apparition | Capture de base |
| ---------- | ---------- | --------------- |
| Commun     | 50 %       | 80 %            |
| Peu commun | 30 %       | 60 %            |
| Rare       | 15 %       | 40 %            |
| Épique     | 4 %        | 20 %            |
| Légendaire | 1 %        | 5 %             |

---

## 4. Système de capture

### 4.1. Formule de capture

```
P(capture) = BaseCapture × (1 + BonusArtefact) × (1 - (NiveauCréature - NiveauJoueur) × 0.02)
```

* **BaseCapture** : dépend de la rareté de la créature.
* **BonusArtefact** : artefacts ultra rares augmentant les chances de capture (ex : +10 %).
* Si la différence de niveau entre la créature et le joueur est négative (créature plus faible), le malus devient un bonus.

### 4.2. Artefacts

* Trouvables dans des **coffres de fin de chasse** (probabilité 1 à 2 %).
* Peuvent :

  * Augmenter la probabilité de capture.
  * Réduire la consommation de ressources.
  * Améliorer les récompenses de chasse.

---

## 5. Guilde des aventuriers

* Progression par **rang** : F → E → D → C → B → A → S → SS → SSS → Ex.
* Chaque capture réussie rapporte **EXP de guilde** selon la rareté et le statut du monstre.
* En cas d’échec de capture, le joueur reçoit uniquement :

  * De l’or.
  * Des ressources spécifiques au monstre.

---

## 6. Système de ressources

### 6.1. Types de ressources

Chaque monstre a sa propre table de loot.
Exemple (Dragon) :

| Ressource          | Probabilité |
| ------------------ | ----------- |
| Écailles de dragon | 60 %        |
| Corne de dragon    | 30 %        |
| Œuf de dragon      | 1 %         |

### 6.2. Utilisation

* **Crafting** : armes, armures et objets spéciaux selon des recettes définies.
* **Échanges entre joueurs**.
* **Œufs** : permettent d’obtenir une créature si la capture a échoué.

---

## 7. Gestion des créatures

* Les monstres capturés peuvent être :

  * Placés dans des **enclos publics** consultables par d’autres joueurs.
  * Vendus aux **enchères**.
  * **Reproduits** avec d'autres créatures de la même espèce.

### 7.1. Reproduction

* Deux créatures de la même espèce peuvent produire un **œuf**.
* Les stats de la créature issue de l’œuf :

  * Moyenne des stats des deux parents.
  * Bonus de statut aléatoire :

    | Statut | Probabilité par défaut |
    | ------ | ---------------------- |
    | Normal | 60 %                   |
    | Élite  | 25 %                   |
    | Alpha  | 12 %                   |
    | Boss   | 3 %                    |

---

## 8. Éléments techniques

### 8.1. Stack technologique recommandé

* **Backend** : PHP (MVC) + PDO pour la base de données.
* **Frontend** : TailwindCSS pour le style.
* **Librairies suggérées** :

  * Chart.js (statistiques et suivi des chasses).
  * Alpine.js ou Livewire (interactions dynamiques).
  * PHPMailer (notifications par mail).
* **Base de données** : MySQL (tables séparées pour joueurs, monstres, captures, ressources, recettes, guilde).

### 8.2. Points clés de développement

* Système de **routing MVC** clair.
* Fichiers séparés pour la logique (ex : `ChasseController`, `CaptureService`).
* Scripts PHP pour gérer les probabilités côté serveur afin d’éviter la triche.
* Gestion des sessions sécurisée.
* API interne pour les échanges (enchères, affichage des enclos publics).

---

Voici un **schéma de base de données complet**

---

## 1️⃣ Schéma général

### Tables principales :

* **`joueurs`** : informations des utilisateurs.
* **`guildes`** : gestion des rangs.
* **`creatures`** : bestiaire de référence.
* **`statuts_creatures`** : normal, élite, alpha, boss.
* **`captures`** : créatures capturées par les joueurs.
* **`ressources`** : ressources de base.
* **`loot_ressources`** : ressources lootables par créature.
* **`inventaire_ressources`** : ressources possédées par les joueurs.
* **`recettes`** : recettes de craft.
* **`recette_ressources`** : ressources nécessaires pour fabriquer un objet.
* **`enclos`** : enclos visibles publiquement.
* **`reproductions`** : historique de reproduction de créatures.
* **`enchères`** : système de mise en vente des créatures.
* **`artefacts`** : objets rares influençant le gameplay.

---

## 2️⃣ Détails des tables

### Table `joueurs`

| Colonne           | Type         | Description              |
| ----------------- | ------------ | ------------------------ |
| id                | INT PK       | Identifiant unique       |
| pseudo            | VARCHAR(50)  | Nom du joueur            |
| email             | VARCHAR(100) | Email du joueur          |
| mot\_de\_passe    | VARCHAR(255) | Mot de passe (hashé)     |
| niveau            | INT          | Niveau global du joueur  |
| rang\_guilde\_id  | INT FK       | Référence vers `guildes` |
| exp\_guilde       | INT          | Expérience de rang       |
| or                | INT          | Or disponible            |
| date\_inscription | DATETIME     | Date d’inscription       |

---

### Table `guildes`

| Colonne      | Type        | Description                                |
| ------------ | ----------- | ------------------------------------------ |
| id           | INT PK      | Identifiant unique                         |
| rang         | VARCHAR(10) | F, E, D, C, B, A, S, SS, SSS, Ex           |
| exp\_requise | INT         | EXP nécessaire pour passer au rang suivant |

---

### Table `creatures`

| Colonne     | Type        | Description                                   |
| ----------- | ----------- | --------------------------------------------- |
| id          | INT PK      | Identifiant unique                            |
| nom         | VARCHAR(50) | Nom de la créature                            |
| rarete      | ENUM        | commun, peu\_commun, rare, epique, legendaire |
| niveau\_max | INT         | Niveau max naturel                            |
| description | TEXT        | Description du monstre                        |

---

### Table `statuts_creatures`

| Colonne               | Type        | Description                |
| --------------------- | ----------- | -------------------------- |
| id                    | INT PK      | Identifiant unique         |
| nom                   | VARCHAR(20) | Normal, Élite, Alpha, Boss |
| multiplicateur\_stats | FLOAT       | Bonus sur les stats        |

---

### Table `captures`

| Colonne           | Type        | Description                        |
| ----------------- | ----------- | ---------------------------------- |
| id                | INT PK      | Identifiant unique                 |
| joueur\_id        | INT FK      | Propriétaire                       |
| creature\_id      | INT FK      | Référence vers `creatures`         |
| statut\_id        | INT FK      | Référence vers `statuts_creatures` |
| niveau            | INT         | Niveau de la créature              |
| nom\_personnalise | VARCHAR(50) | Nom donné par le joueur            |
| date\_capture     | DATETIME    | Date de capture                    |
| enclos\_id        | INT FK NULL | Si la créature est exposée         |

---

### Table `ressources`

| Colonne     | Type        | Description         |
| ----------- | ----------- | ------------------- |
| id          | INT PK      | Identifiant unique  |
| nom         | VARCHAR(50) | Nom de la ressource |
| description | TEXT        | Description         |

---

### Table `loot_ressources`

| Colonne       | Type   | Description                     |
| ------------- | ------ | ------------------------------- |
| id            | INT PK | Identifiant unique              |
| creature\_id  | INT FK | Référence vers `creatures`      |
| ressource\_id | INT FK | Référence vers `ressources`     |
| probabilite   | FLOAT  | Probabilité de drop (0.01 = 1%) |

---

### Table `inventaire_ressources`

| Colonne       | Type   | Description                 |
| ------------- | ------ | --------------------------- |
| id            | INT PK | Identifiant unique          |
| joueur\_id    | INT FK | Propriétaire                |
| ressource\_id | INT FK | Référence vers `ressources` |
| quantite      | INT    | Quantité possédée           |

---

### Table `recettes`

| Colonne     | Type        | Description        |
| ----------- | ----------- | ------------------ |
| id          | INT PK      | Identifiant unique |
| nom         | VARCHAR(50) | Nom de l’objet     |
| description | TEXT        | Description        |

---

### Table `recette_ressources`

| Colonne       | Type   | Description                 |
| ------------- | ------ | --------------------------- |
| id            | INT PK | Identifiant unique          |
| recette\_id   | INT FK | Référence vers `recettes`   |
| ressource\_id | INT FK | Référence vers `ressources` |
| quantite      | INT    | Quantité requise            |

---

### Table `enclos`

| Colonne    | Type        | Description              |
| ---------- | ----------- | ------------------------ |
| id         | INT PK      | Identifiant unique       |
| joueur\_id | INT FK      | Propriétaire de l’enclos |
| nom        | VARCHAR(50) | Nom de l’enclos          |

---

### Table `reproductions`

| Colonne            | Type     | Description               |
| ------------------ | -------- | ------------------------- |
| id                 | INT PK   | Identifiant unique        |
| creature\_parent1  | INT FK   | Référence vers `captures` |
| creature\_parent2  | INT FK   | Référence vers `captures` |
| oeuf\_statut\_id   | INT FK   | Statut de l’œuf généré    |
| date\_reproduction | DATETIME | Date de reproduction      |

---

### Table `enchères`

| Colonne      | Type     | Description               |
| ------------ | -------- | ------------------------- |
| id           | INT PK   | Identifiant unique        |
| creature\_id | INT FK   | Référence vers `captures` |
| vendeur\_id  | INT FK   | Joueur vendeur            |
| prix\_depart | INT      | Prix de départ            |
| date\_debut  | DATETIME | Début de l’enchère        |
| date\_fin    | DATETIME | Fin de l’enchère          |

---

### Table `artefacts`

| Colonne | Type        | Description                      |
| ------- | ----------- | -------------------------------- |
| id      | INT PK      | Identifiant unique               |
| nom     | VARCHAR(50) | Nom de l’artefact                |
| effet   | TEXT        | Description de l’effet           |
| rarete  | ENUM        | commun, rare, epique, legendaire |

---

```sql
CREATE TABLE guildes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rang VARCHAR(10) NOT NULL,
    exp_requise INT NOT NULL
);

CREATE TABLE joueurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    niveau INT DEFAULT 1,
    rang_guilde_id INT,
    exp_guilde INT DEFAULT 0,
    or INT DEFAULT 0,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rang_guilde_id) REFERENCES guildes(id)
);

CREATE TABLE creatures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    rarete ENUM('commun','peu_commun','rare','epique','legendaire') NOT NULL,
    niveau_max INT NOT NULL,
    description TEXT
);

CREATE TABLE statuts_creatures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(20) NOT NULL,
    multiplicateur_stats FLOAT NOT NULL
);

CREATE TABLE enclos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    joueur_id INT NOT NULL,
    nom VARCHAR(50),
    FOREIGN KEY (joueur_id) REFERENCES joueurs(id)
);

CREATE TABLE captures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    joueur_id INT NOT NULL,
    creature_id INT NOT NULL,
    statut_id INT NOT NULL,
    niveau INT NOT NULL,
    nom_personnalise VARCHAR(50),
    date_capture DATETIME DEFAULT CURRENT_TIMESTAMP,
    enclos_id INT NULL,
    FOREIGN KEY (joueur_id) REFERENCES joueurs(id),
    FOREIGN KEY (creature_id) REFERENCES creatures(id),
    FOREIGN KEY (statut_id) REFERENCES statuts_creatures(id),
    FOREIGN KEY (enclos_id) REFERENCES enclos(id)
);

CREATE TABLE ressources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE loot_ressources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creature_id INT NOT NULL,
    ressource_id INT NOT NULL,
    probabilite FLOAT NOT NULL,
    FOREIGN KEY (creature_id) REFERENCES creatures(id),
    FOREIGN KEY (ressource_id) REFERENCES ressources(id)
);

CREATE TABLE inventaire_ressources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    joueur_id INT NOT NULL,
    ressource_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 0,
    FOREIGN KEY (joueur_id) REFERENCES joueurs(id),
    FOREIGN KEY (ressource_id) REFERENCES ressources(id)
);

CREATE TABLE recettes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE recette_ressources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recette_id INT NOT NULL,
    ressource_id INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY (recette_id) REFERENCES recettes(id),
    FOREIGN KEY (ressource_id) REFERENCES ressources(id)
);

CREATE TABLE reproductions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creature_parent1 INT NOT NULL,
    creature_parent2 INT NOT NULL,
    oeuf_statut_id INT NOT NULL,
    date_reproduction DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creature_parent1) REFERENCES captures(id),
    FOREIGN KEY (creature_parent2) REFERENCES captures(id),
    FOREIGN KEY (oeuf_statut_id) REFERENCES statuts_creatures(id)
);

CREATE TABLE enchères (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creature_id INT NOT NULL,
    vendeur_id INT NOT NULL,
    prix_depart INT NOT NULL,
    date_debut DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_fin DATETIME NOT NULL,
    FOREIGN KEY (creature_id) REFERENCES captures(id),
    FOREIGN KEY (vendeur_id) REFERENCES joueurs(id)
);

CREATE TABLE artefacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    effet TEXT NOT NULL,
    rarete ENUM('commun','rare','epique','legendaire') NOT NULL
);


-- Insertion des rangs de guilde
INSERT INTO guildes (rang, exp_requise) VALUES
('F', 0),
('E', 100),
('D', 250),
('C', 500),
('B', 1000),
('A', 2000),
('S', 5000),
('SS', 10000),
('SSS', 20000),
('Ex', 50000);

-- Insertion des statuts de créature
INSERT INTO statuts_creatures (nom, multiplicateur_stats) VALUES
('Normal', 1.0),
('Élite', 1.2),
('Alpha', 1.5),
('Boss', 2.0);

-- Insertion des créatures
INSERT INTO creatures (nom, rarete, niveau_max, description) VALUES
('Gobelin', 'commun', 20, 'Petit monstre agressif vivant en groupe.'),
('Loup', 'peu_commun', 25, 'Prédateur rapide et féroce.'),
('Griffon', 'rare', 40, 'Créature majestueuse mi-lion mi-aigle.'),
('Dragon', 'epique', 60, 'Bête légendaire crachant du feu.'),
('Phénix', 'legendaire', 70, 'Oiseau mythique renaissant de ses cendres.');

-- Insertion de ressources
INSERT INTO ressources (nom, description) VALUES
('Peau de gobelin', 'Matériau de base pour l'artisanat.'),
('Griffe de loup', 'Utilisée pour fabriquer des armes légères.'),
('Plume de griffon', 'Ressource rare utilisée pour des objets magiques.'),
('Écaille de dragon', 'Matériau solide pour armures puissantes.'),
('Cendre de phénix', 'Ingrédient mythique pour des potions de résurrection.'),
('Œuf de dragon', 'Peut éclore pour obtenir un bébé dragon.');

-- Insertion du loot des ressources
INSERT INTO loot_ressources (creature_id, ressource_id, probabilite) VALUES
(1, 1, 0.7),  -- Gobelin → Peau de gobelin
(2, 2, 0.6),  -- Loup → Griffe de loup
(3, 3, 0.4),  -- Griffon → Plume de griffon
(4, 4, 0.6),  -- Dragon → Écaille de dragon
(4, 6, 0.01), -- Dragon → Œuf de dragon
(5, 5, 0.3);  -- Phénix → Cendre de phénix

-- Insertion de recettes
INSERT INTO recettes (nom, description) VALUES
('Épée du Loup', 'Arme légère fabriquée avec des griffes de loup.'),
('Armure draconique', 'Armure lourde fabriquée avec des écailles de dragon.'),
('Potion de renaissance', 'Potion rare fabriquée avec de la cendre de phénix.');

-- Ressources nécessaires pour les recettes
INSERT INTO recette_ressources (recette_id, ressource_id, quantite) VALUES
(1, 2, 5),  -- Épée du Loup → 5 Griffes de loup
(2, 4, 10), -- Armure draconique → 10 Écailles de dragon
(3, 5, 3);  -- Potion de renaissance → 3 Cendres de phénix
```

---

## 1️⃣ Structure des dossiers

```
/chasse-monstres
│
│── index.php          # Point d'entrée (front controller)
│── .htaccess          # Réécriture d'URL pour Apache
│
├── app
│   ├── core
│   │   ├── Router.php     # Gestion des routes
│   │   ├── Controller.php # Classe de base pour les controllers
│   │   ├── Model.php      # Classe de base pour les models (PDO)
│   │   └── Database.php   # Connexion PDO
│   │
│   ├── controllers
│   │   ├── ChasseController.php
│   │   ├── JoueurController.php
│   │   ├── CreatureController.php
│   │   └── GuildeController.php
│   │
│   ├── models
│   │   ├── Joueur.php
│   │   ├── Creature.php
│   │   ├── Capture.php
│   │   ├── Ressource.php
│   │   └── Guilde.php
│   │
│   ├── views
│   │   ├── layout.php         # Template principal
│   │   ├── chasse
│   │   │   └── index.php
│   │   ├── joueur
│   │   │   ├── profil.php
│   │   │   └── login.php
│   │   └── creature
│   │       └── liste.php
│   │
│   └── config
│       └── config.php     # Paramètres globaux
```

---

## 2️⃣ Exemple Fichiers clés

### `index.php`

```php
<?php
require_once __DIR__ . '/app/core/Router.php';
require_once __DIR__ . '/app/config/config.php';

$router = new Router();
$router->dispatch();
```

---

### `.htaccess`

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

---

### `app/config/config.php`

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'chasse_monstres');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', '/');
```

---

### `app/core/Database.php`

```php
<?php
class Database {
    private static $instance = null;
    public static function getConnection() {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
            self::$instance = new PDO($dsn, DB_USER, DB_PASS);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}
```

---

### `app/core/Router.php`

```php
<?php
class Router {
    public function dispatch() {
        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'ChasseController';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Méthode $method introuvable.";
            }
        } else {
            echo "Contrôleur $controllerName introuvable.";
        }
    }
}
```

---

### `app/core/Controller.php`

```php
<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    protected function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }
}
```

---

### `app/core/Model.php`

```php
<?php
class Model {
    protected $db;
    public function __construct() {
        $this->db = Database::getConnection();
    }
}
```

---

### `app/controllers/ChasseController.php`

```php
<?php
class ChasseController extends Controller {
    public function index() {
        $creatureModel = $this->model('Creature');
        $creatures = $creatureModel->getAll();
        $this->view('chasse/index', ['creatures' => $creatures]);
    }
}
```

---

### `app/models/Creature.php`

```php
<?php
class Creature extends Model {
    public function getAll() {
        $query = $this->db->query("SELECT * FROM creatures");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

---

### `app/views/chasse/index.php`

```php
<?php include __DIR__ . '/../layout.php'; ?>

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Chasse aux monstres</h1>
    <ul>
        <?php foreach ($creatures as $creature): ?>
            <li class="border p-2 mb-2 rounded">
                <?= htmlspecialchars($creature['nom']) ?> - Rareté: <?= htmlspecialchars($creature['rarete']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
```

---