<?php
$title = ($captureResult['success'] ? 'Capture réussie' : 'Capture échouée') . ' - Monster Hunter RPG';
ob_start();
?>

<div class="max-w-4xl mx-auto space-y-8">
    <?php if ($captureResult['success']): ?>
    <!-- Succès -->
    <div class="text-center">
        <div class="text-8xl mb-4 animate-bounce">🎉</div>
        <h1 class="text-4xl font-bold text-green-400 mb-4">
            <i class="fas fa-check-circle mr-2"></i>Capture réussie !
        </h1>
        <p class="text-gray-300 text-lg">Félicitations ! Vous avez capturé la créature avec succès !</p>
    </div>
    
    <div class="bg-dark-card/80 backdrop-blur-sm rounded-2xl p-8 border border-green-500/30 text-center">
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
        
        <div class="bg-green-500/20 rounded-lg p-6 mb-6">
            <h3 class="text-xl font-bold text-green-400 mb-4">Récompenses obtenues</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-400">+<?= $captureResult['exp_gained'] ?></div>
                    <div class="text-gray-400">EXP de guilde</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-cyber-blue">
                        <i class="fas fa-plus mr-1"></i>1
                    </div>
                    <div class="text-gray-400">Créature capturée</div>
                </div>
            </div>
            
            <?php if ($captureResult['rank_up']): ?>
            <div class="mt-6 p-4 bg-yellow-500/20 rounded-lg border border-yellow-500/50">
                <p class="text-yellow-300 font-bold">
                    <i class="fas fa-arrow-up mr-2"></i>Montée de rang ! Vous avez progressé dans la guilde !
                </p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="space-x-4">
            <a href="<?= BASE_URL ?>collection" 
               class="bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink px-8 py-3 rounded-lg font-semibold text-dark-bg transition-all">
                <i class="fas fa-book mr-2"></i>Voir ma collection
            </a>
            <a href="<?= BASE_URL ?>chasse" 
               class="border-2 border-cyber-blue hover:bg-cyber-blue hover:text-dark-bg px-8 py-3 rounded-lg font-semibold transition-all">
                <i class="fas fa-redo mr-2"></i>Nouvelle chasse
            </a>
        </div>
    </div>
    
    <?php else: ?>
    <!-- Échec -->
    <div class="text-center">
        <div class="text-8xl mb-4">😞</div>
        <h1 class="text-4xl font-bold text-red-400 mb-4">
            <i class="fas fa-times-circle mr-2"></i>Capture échouée
        </h1>
        <p class="text-gray-300 text-lg">La créature s'est échappée, mais vous obtenez quand même des récompenses !</p>
    </div>
    
    <div class="bg-dark-card/80 backdrop-blur-sm rounded-2xl p-8 border border-red-500/30 text-center">
        <div class="mb-6">
            <h2 class="text-3xl font-bold rarity-<?= $huntResult['creature']['rarete'] ?> mb-4">
                <?= htmlspecialchars($huntResult['creature']['nom']) ?> s'est échappé...
            </h2>
        </div>
        
        <div class="bg-yellow-500/20 rounded-lg p-6 mb-6">
            <h3 class="text-xl font-bold text-yellow-400 mb-4">Récompenses de consolation</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400">+<?= $captureResult['rewards']['gold'] ?></div>
                    <div class="text-gray-400">Or</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400"><?= count($captureResult['rewards']['resources']) ?></div>
                    <div class="text-gray-400">Ressources</div>
                </div>
            </div>
            
            <?php if (!empty($captureResult['rewards']['resources'])): ?>
            <div class="mt-4">
                <h4 class="font-semibold text-gray-300 mb-2">Ressources obtenues :</h4>
                <div class="flex flex-wrap justify-center gap-2">
                    <?php foreach ($captureResult['rewards']['resources'] as $resource): ?>
                    <span class="bg-dark-accent px-3 py-1 rounded-full text-sm text-green-400">
                        <i class="fas fa-leaf mr-1"></i><?= htmlspecialchars($resource) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
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
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>