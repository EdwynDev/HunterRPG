<?php
$title = 'Connexion - Monster Hunter RPG';
ob_start();
?>

<div class="max-w-md mx-auto animate-fade-in">
    <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-black mb-2">
                <i class="fas fa-sign-in-alt mr-2"></i>Connexion
            </h1>
            <p class="text-gray-600">Accédez à votre compte d'aventurier</p>
        </div>
        
        <?php if (!empty($error)): ?>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <p class="text-red-700"><i class="fas fa-exclamation-triangle mr-2"></i><?= htmlspecialchars($error) ?></p>
        </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-1"></i>Email
                </label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-black focus:ring-1 focus:ring-black transition-colors"
                       placeholder="votre@email.com">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1"></i>Mot de passe
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-black focus:ring-1 focus:ring-black transition-colors"
                       placeholder="••••••••">
            </div>
            
            <button type="submit" 
                    class="w-full btn-primary text-white py-3 rounded-lg font-medium">
                <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
            </button>
        </form>
        
        <div class="text-center mt-6">
            <p class="text-gray-600">
                Pas encore de compte ? 
                <a href="<?= BASE_URL ?>auth/register" class="text-black hover:text-gray-700 transition-colors font-medium">
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