<?php
require_once __DIR__ . '/../core/Controller.php';

class AuthController extends Controller {
    
    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('');
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = 'Veuillez remplir tous les champs.';
            } else {
                $joueurModel = $this->model('Joueur');
                $joueur = $joueurModel->getByEmail($email);
                
                if ($joueur && password_verify($password, $joueur['mot_de_passe'])) {
                    $_SESSION['joueur_id'] = $joueur['id'];
                    $_SESSION['pseudo'] = $joueur['pseudo'];
                    $this->redirect('');
                } else {
                    $error = 'Email ou mot de passe incorrect.';
                }
            }
        }
        
        $this->view('auth/login', ['error' => $error]);
    }
    
    public function register() {
        if ($this->isLoggedIn()) {
            $this->redirect('');
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = $_POST['pseudo'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($pseudo) || empty($email) || empty($password) || empty($confirmPassword)) {
                $error = 'Veuillez remplir tous les champs.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Les mots de passe ne correspondent pas.';
            } elseif (strlen($password) < 6) {
                $error = 'Le mot de passe doit contenir au moins 6 caractères.';
            } else {
                $joueurModel = $this->model('Joueur');
                
                // Vérifier si l'email existe déjà
                if ($joueurModel->getByEmail($email)) {
                    $error = 'Cet email est déjà utilisé.';
                } else {
                    try {
                        $joueurId = $joueurModel->create($pseudo, $email, $password);
                        $success = 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.';
                    } catch (Exception $e) {
                        $error = 'Erreur lors de la création du compte.';
                    }
                }
            }
        }
        
        $this->view('auth/register', ['error' => $error, 'success' => $success]);
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('');
    }
}