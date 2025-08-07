<?php
$title = 'Inscription - Monster Hunter RPG';
ob_start();
?>

<div class="max-w-md mx-auto">
    <div class="bg-dark-card/80 backdrop-blur-sm rounded-2xl p-8 border border-cyber-blue/30">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-cyber-blue mb-2">
                <i class="fas fa-user-plus mr-2"></i>Inscription
            </h1>
            <p class="text-gray-400">Rejoignez la guilde des aventuriers</p>
        </div>
        
        <?php if (!empty($error)): ?>
        <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 mb-6">
            <p class="text-red-300"><i class="fas fa-exclamation-triangle mr-2"></i><?= htmlspecialchars($error) ?></p>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
        <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 mb-6">
            <p class="text-green-300"><i class="fas fa-check-circle mr-2"></i><?= htmlspecialchars($success) ?></p>
        </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-6">
            <div>
                <label for="pseudo" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-user mr-1"></i>Pseudo
                </label>
                <input type="text" id="pseudo" name="pseudo" required
                       class="w-full px-4 py-3 bg-dark-accent border border-gray-600 rounded-lg focus:border-cyber-blue focus:ring-1 focus:ring-cyber-blue transition-colors text-white"
                       placeholder="Votre pseudo d'aventurier">
            </div>
            
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
            
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-lock mr-1"></i>Confirmer le mot de passe
                </label>
                <input type="password" id="confirm_password" name="confirm_password" required
                       class="w-full px-4 py-3 bg-dark-accent border border-gray-600 rounded-lg focus:border-cyber-blue focus:ring-1 focus:ring-cyber-blue transition-colors text-white"
                       placeholder="••••••••">
            </div>
            
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink py-3 rounded-lg font-semibold text-dark-bg transition-all transform hover:scale-105">
                <i class="fas fa-user-plus mr-2"></i>Créer mon compte
            </button>
        </form>
        
        <div class="text-center mt-6">
            <p class="text-gray-400">
                Déjà un compte ? 
                <a href="<?= BASE_URL ?>auth/login" class="text-cyber-blue hover:text-cyber-purple transition-colors">
                    Se connecter
                </a>
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>