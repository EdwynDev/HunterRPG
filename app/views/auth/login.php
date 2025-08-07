<?php
$title = 'Connexion - Monster Hunter RPG';
ob_start();
?>

<div class="max-w-md mx-auto">
    <div class="bg-dark-card/80 backdrop-blur-sm rounded-2xl p-8 border border-cyber-blue/30">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-cyber-blue mb-2">
                <i class="fas fa-sign-in-alt mr-2"></i>Connexion
            </h1>
            <p class="text-gray-400">Accédez à votre compte d'aventurier</p>
        </div>
        
        <?php if (!empty($error)): ?>
        <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 mb-6">
            <p class="text-red-300"><i class="fas fa-exclamation-triangle mr-2"></i><?= htmlspecialchars($error) ?></p>
        </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-envelope mr-1"></i>Email
                </label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 bg-dark-accent border border-gray-600 rounded-lg focus:border-cyber-blue focus:ring-1 focus:ring-cyber-blue transition-colors text-white"
                       placeholder="votre@email.com">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-lock mr-1"></i>Mot de passe
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 bg-dark-accent border border-gray-600 rounded-lg focus:border-cyber-blue focus:ring-1 focus:ring-cyber-blue transition-colors text-white"
                       placeholder="••••••••">
            </div>
            
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink py-3 rounded-lg font-semibold text-dark-bg transition-all transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
            </button>
        </form>
        
        <div class="text-center mt-6">
            <p class="text-gray-400">
                Pas encore de compte ? 
                <a href="<?= BASE_URL ?>auth/register" class="text-cyber-blue hover:text-cyber-purple transition-colors">
                    Créer un compte
                </a>
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>