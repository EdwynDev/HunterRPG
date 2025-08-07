<?php
$title = 'Créature éliminée - Monster Hunter RPG';
ob_start();
?>

<div class="max-w-4xl mx-auto space-y-8">
    <div class="text-center">
        <div class="text-8xl mb-4">⚔️</div>
        <h1 class="text-4xl font-bold text-red-400 mb-4">
            <i class="fas fa-skull mr-2"></i>Créature éliminée
        </h1>
        <p class="text-gray-300 text-lg">Vous avez vaincu la créature et récupéré des ressources précieuses !</p>
    </div>
    
    <div class="bg-dark-card/80 backdrop-blur-sm rounded-2xl p-8 border border-red-500/30 text-center">
        <div class="mb-6">
            <h2 class="text-3xl font-bold rarity-<?= $huntResult['creature']['rarete'] ?> mb-4">
                <?= htmlspecialchars($huntResult['creature']['nom']) ?>
                <span class="status-<?= strtolower(str_replace('é', 'e', $huntResult['statut']['nom'])) ?>">
                    (<?= $huntResult['statut']['nom'] ?>)
                </span>
            </h2>
            
            <div class="text-2xl font-bold text-cyber-blue mb-4">
                Niveau <?= $huntResult['niveau'] ?>
            </div>
        </div>
        
        <div class="bg-yellow-500/20 rounded-lg p-6 mb-6">
            <h3 class="text-xl font-bold text-yellow-400 mb-4">Butin récupéré</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">+<?= $rewards['gold'] ?></div>
                    <div class="text-gray-400">Or</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400"><?= count($rewards['resources']) ?></div>
                    <div class="text-gray-400">Ressources</div>
                </div>
            </div>
            
            <?php if (!empty($rewards['resources'])): ?>
            <div class="mt-4">
                <h4 class="font-semibold text-gray-300 mb-2">Ressources obtenues :</h4>
                <div class="flex flex-wrap justify-center gap-2">
                    <?php foreach ($rewards['resources'] as $resource): ?>
                    <span class="bg-dark-accent px-3 py-1 rounded-full text-sm text-green-400">
                        <i class="fas fa-leaf mr-1"></i><?= htmlspecialchars($resource) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="mt-4 text-gray-400">
                <p>Aucune ressource spéciale cette fois-ci, mais vous avez gagné de l'or !</p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="space-x-4">
            <a href="<?= BASE_URL ?>chasse" 
               class="bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink px-8 py-3 rounded-lg font-semibold text-dark-bg transition-all">
                <i class="fas fa-redo mr-2"></i>Nouvelle chasse
            </a>
            <a href="<?= BASE_URL ?>" 
               class="border-2 border-cyber-blue hover:bg-cyber-blue hover:text-dark-bg px-8 py-3 rounded-lg font-semibold transition-all">
                <i class="fas fa-home mr-2"></i>Retour à l'accueil
            </a>
        </div>
    </div>
    
    <!-- Informations sur les ressources -->
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
        <h3 class="text-xl font-bold text-cyber-blue mb-4">
            <i class="fas fa-info-circle mr-2"></i>À propos des ressources
        </h3>
        <div class="text-gray-300 space-y-2">
            <p><i class="fas fa-hammer text-yellow-400 mr-2"></i>Les ressources peuvent être utilisées pour l'artisanat</p>
            <p><i class="fas fa-exchange-alt text-green-400 mr-2"></i>Échangez avec d'autres joueurs pour obtenir ce dont vous avez besoin</p>
            <p><i class="fas fa-egg text-purple-400 mr-2"></i>Les œufs rares peuvent éclore en créatures si vous échouez une capture</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>