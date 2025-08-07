<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'u316670446_hunterrpg');
define('DB_USER', 'u316670446_hunterrpg');
define('DB_PASS', '6H40G+bK');
define('BASE_URL', '/');

// Configuration du jeu
define('RARITY_PROBABILITIES', [
    'commun' => 0.50,
    'peu_commun' => 0.30,
    'rare' => 0.15,
    'epique' => 0.04,
    'legendaire' => 0.01
]);

define('STATUS_PROBABILITIES', [
    1 => 0.70, // Normal
    2 => 0.20, // Élite
    3 => 0.09, // Alpha
    4 => 0.01  // Boss
]);

define('CAPTURE_BASE_RATES', [
    'commun' => 0.80,
    'peu_commun' => 0.60,
    'rare' => 0.40,
    'epique' => 0.20,
    'legendaire' => 0.05
]);