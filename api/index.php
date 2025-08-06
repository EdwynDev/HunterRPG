<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Simple routing
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = str_replace('/api', '', $path);
$method = $_SERVER['REQUEST_METHOD'];

// Mock responses for demo
switch ($path) {
    case '/creatures':
        if ($method === 'GET') {
            echo json_encode([
                ['id' => 1, 'nom' => 'Gobelin', 'rarete' => 'commun', 'niveau_max' => 20, 'description' => 'Petit monstre agressif vivant en groupe.'],
                ['id' => 2, 'nom' => 'Loup', 'rarete' => 'peu_commun', 'niveau_max' => 25, 'description' => 'Prédateur rapide et féroce.'],
                ['id' => 3, 'nom' => 'Griffon', 'rarete' => 'rare', 'niveau_max' => 40, 'description' => 'Créature majestueuse mi-lion mi-aigle.'],
                ['id' => 4, 'nom' => 'Dragon', 'rarete' => 'epique', 'niveau_max' => 60, 'description' => 'Bête légendaire crachant du feu.'],
                ['id' => 5, 'nom' => 'Phénix', 'rarete' => 'legendaire', 'niveau_max' => 70, 'description' => 'Oiseau mythique renaissant de ses cendres.']
            ]);
        }
        break;
        
    case '/guilds':
        if ($method === 'GET') {
            echo json_encode([
                ['id' => 1, 'rang' => 'F', 'exp_requise' => 0],
                ['id' => 2, 'rang' => 'E', 'exp_requise' => 100],
                ['id' => 3, 'rang' => 'D', 'exp_requise' => 250],
                ['id' => 4, 'rang' => 'C', 'exp_requise' => 500],
                ['id' => 5, 'rang' => 'B', 'exp_requise' => 1000],
                ['id' => 6, 'rang' => 'A', 'exp_requise' => 2000],
                ['id' => 7, 'rang' => 'S', 'exp_requise' => 5000],
                ['id' => 8, 'rang' => 'SS', 'exp_requise' => 10000],
                ['id' => 9, 'rang' => 'SSS', 'exp_requise' => 20000],
                ['id' => 10, 'rang' => 'Ex', 'exp_requise' => 50000]
            ]);
        }
        break;
        
    case '/auth/login':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            // Mock successful login
            echo json_encode([
                'success' => true,
                'token' => 'mock_token_' . time(),
                'user' => [
                    'id' => 1,
                    'pseudo' => 'DemoUser',
                    'email' => $input['email'] ?? 'demo@example.com'
                ]
            ]);
        }
        break;
        
    case '/auth/register':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            // Mock successful registration
            echo json_encode([
                'success' => true,
                'token' => 'mock_token_' . time(),
                'user' => [
                    'id' => time(),
                    'pseudo' => $input['pseudo'] ?? 'NewUser',
                    'email' => $input['email'] ?? 'new@example.com'
                ]
            ]);
        }
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
?>