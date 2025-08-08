<?php
$title = ($captureResult['success'] ? 'Capture réussie' : 'Capture échouée') . ' - Monster Hunter RPG';
ob_start();
?>

<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <?php if ($captureResult['success']): ?>
    <!-- Succès -->
    <div class="text-center">
        <div class="text-8xl mb-4">🎉</div>
        <h1 class="text-4xl font-bold text-green-600 mb-4">
            <i class="fas fa-check-circle mr-2"></i>Capture réussie !
        </h1>
        <p class="text-gray-600 text-lg">Félicitations ! Vous avez capturé la créature avec succès !</p>
    </div>
    
    <div class="bg-white rounded-2xl p-8 border border-green-200 text-center card-hover">
        <div class="mb-6">
            <h2 class="text-3xl font-bold rarity-<?= $huntResult['creature']['rarete'] ?> mb-4">
                <?= htmlspecialchars($huntResult['creature']['nom']) ?>
                <span class="status-<?= strtolower(str_replace('é', 'e', $huntResult['statut']['nom'])) ?>">
                    (<?= $huntResult['statut']['nom'] ?>)
                </span>
            </h2>
            
            <div class="text-2xl font-bold text-black mb-4">
                Niveau <?= $huntResult['niveau'] ?>
            </div>
        </div>
        
        <div class="bg-green-50 rounded-lg p-6 mb-6 border border-green-200">
            <h3 class="text-xl font-bold text-green-700 mb-4">Récompenses obtenues</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center p-4 bg-white rounded-lg border border-green-100">
                    <div class="text-3xl font-bold text-purple-600 mb-1">+<?= $captureResult['exp_gained'] ?></div>
                    <div class="text-gray-500 text-sm">EXP de guilde</div>
                </div>
                <div class="text-center p-4 bg-white rounded-lg border border-green-100">
                    <div class="text-3xl font-bold text-black mb-1">
                        <i class="fas fa-plus mr-1"></i>1
                    </div>
                    <div class="text-gray-500 text-sm">Créature capturée</div>
                </div>
            </div>
            
            <?php if ($captureResult['rank_up']): ?>
            <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <p class="text-yellow-700 font-bold">
                    <i class="fas fa-arrow-up mr-2"></i>Montée de rang ! Vous avez progressé dans la guilde !
                </p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= BASE_URL ?>collection" 
               class="btn-primary text-white px-8 py-3 rounded-lg font-medium">
                <i class="fas fa-book mr-2"></i>Voir ma collection
            </a>
            <a href="<?= BASE_URL ?>chasse" 
               class="btn-secondary text-gray-700 px-8 py-3 rounded-lg font-medium">
                <i class="fas fa-redo mr-2"></i>Nouvelle chasse
            </a>
        </div>
    </div>
    
    <?php else: ?>
    <!-- Échec -->
    <div class="text-center">
        <div class="text-8xl mb-4">😞</div>
        <h1 class="text-4xl font-bold text-red-600 mb-4">
            <i class="fas fa-times-circle mr-2"></i>Capture échouée
        </h1>
        <p class="text-gray-600 text-lg">La créature s'est échappée, mais vous obtenez quand même des récompenses !</p>
    </div>
    
    <div class="bg-white rounded-2xl p-8 border border-red-200 text-center card-hover">
        <div class="mb-6">
            <h2 class="text-3xl font-bold rarity-<?= $huntResult['creature']['rarete'] ?> mb-4">
                <?= htmlspecialchars($huntResult['creature']['nom']) ?> s'est échappé...
            </h2>
        </div>
        
        <div class="bg-yellow-50 rounded-lg p-6 mb-6 border border-yellow-200">
            <h3 class="text-xl font-bold text-yellow-700 mb-4">Récompenses de consolation</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center p-4 bg-white rounded-lg border border-yellow-100">
                    <div class="text-3xl font-bold text-yellow-600 mb-1">+<?= $captureResult['rewards']['gold'] ?></div>
                    <div class="text-gray-500 text-sm">Or</div>
                </div>
                <div class="text-center p-4 bg-white rounded-lg border border-yellow-100">
                    <div class="text-3xl font-bold text-green-600 mb-1"><?= count($captureResult['rewards']['resources']) ?></div>
                    <div class="text-gray-500 text-sm">Ressources</div>
                </div>
            </div>
            
            <?php if (!empty($captureResult['rewards']['resources'])): ?>
            <div class="mt-4">
                <h4 class="font-semibold text-gray-700 mb-2">Ressources obtenues :</h4>
                <div class="flex flex-wrap justify-center gap-2">
                    <?php foreach ($captureResult['rewards']['resources'] as $resource): ?>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-leaf mr-1"></i><?= htmlspecialchars($resource['nom']) ?> x<?= $resource['quantite'] ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= BASE_URL ?>chasse" 
               class="btn-primary text-white px-8 py-3 rounded-lg font-medium">
                <i class="fas fa-redo mr-2"></i>Nouvelle chasse
            </a>
            <a href="<?= BASE_URL ?>" 
               class="btn-secondary text-gray-700 px-8 py-3 rounded-lg font-medium">
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