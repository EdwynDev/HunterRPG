<?php
$title = 'Page non trouvée - Monster Hunter RPG';
ob_start();
?>

<div class="text-center py-16">
    <div class="text-8xl mb-8">🔍</div>
    <h1 class="text-6xl font-bold text-cyber-blue mb-4">404</h1>
    <h2 class="text-2xl font-bold text-gray-300 mb-4">Page non trouvée</h2>
    <p class="text-gray-400 text-lg mb-8">
        La page que vous cherchez semble avoir été dévorée par un dragon...
    </p>
    
    <div class="space-x-4">
        <a href="<?= BASE_URL ?>" 
           class="bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink px-8 py-3 rounded-lg font-semibold text-dark-bg transition-all">
            <i class="fas fa-home mr-2"></i>Retour à l'accueil
        </a>
        <a href="<?= BASE_URL ?>chasse" 
           class="border-2 border-cyber-blue hover:bg-cyber-blue hover:text-dark-bg px-8 py-3 rounded-lg font-semibold transition-all">
            <i class="fas fa-crosshairs mr-2"></i>Partir en chasse
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>