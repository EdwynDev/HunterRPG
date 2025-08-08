<?php
$title = 'Rencontre - Monster Hunter RPG';
ob_start();
?>

<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-black mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>Créature détectée !
        </h1>
        <p class="text-gray-600 text-lg">Une créature sauvage apparaît devant vous...</p>
    </div>
    
    <!-- Créature rencontrée -->
    <div class="bg-white rounded-2xl p-8 border border-gray-200 text-center card-hover">
        <div class="mb-6">
            <div class="text-8xl mb-4">
                <?php
                $creatureEmojis = [
                    'Gobelin' => '👹',
                    'Loup' => '🐺',
                    'Griffon' => '🦅',
                    'Dragon' => '🐉',
                    'Phénix' => '🔥'
                ];
                echo $creatureEmojis[$huntResult['creature']['nom']] ?? '👾';
                ?>
            </div>
            
            <h2 class="text-4xl font-bold rarity-<?= $huntResult['creature']['rarete'] ?> mb-2">
                <?= htmlspecialchars($huntResult['creature']['nom']) ?>
            </h2>
            
            <div class="flex justify-center items-center space-x-6 text-lg">
                <span class="status-<?= strtolower(str_replace('é', 'e', $huntResult['statut']['nom'])) ?> font-medium">
                    <i class="fas fa-star mr-1"></i><?= $huntResult['statut']['nom'] ?>
                </span>
                <span class="text-black font-medium">
                    <i class="fas fa-level-up-alt mr-1"></i>Niveau <?= $huntResult['niveau'] ?>
                </span>
                <span class="rarity-<?= $huntResult['creature']['rarete'] ?> font-medium">
                    <i class="fas fa-gem mr-1"></i><?= ucfirst(str_replace('_', ' ', $huntResult['creature']['rarete'])) ?>
                </span>
            </div>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
            <p class="text-gray-700 text-lg mb-4"><?= htmlspecialchars($huntResult['creature']['description']) ?></p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div class="p-4 bg-white rounded-lg border border-gray-100">
                    <div class="text-2xl font-bold text-black mb-1"><?= $huntResult['stats'] ?></div>
                    <div class="text-gray-500 text-sm">Puissance</div>
                </div>
                <div class="p-4 bg-white rounded-lg border border-gray-100">
                    <div class="text-2xl font-bold text-green-600 mb-1"><?= round($huntResult['capture_rate'] * 100, 1) ?>%</div>
                    <div class="text-gray-500 text-sm">Chance de capture</div>
                </div>
                <div class="p-4 bg-white rounded-lg border border-gray-100">
                    <div class="text-2xl font-bold text-purple-600 mb-1">×<?= $huntResult['statut']['multiplicateur_stats'] ?></div>
                    <div class="text-gray-500 text-sm">Multiplicateur</div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <form method="POST" action="<?= BASE_URL ?>chasse/capture" class="flex-1 max-w-xs">
                <button type="submit" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-lg text-lg font-medium transition-colors">
                    <i class="fas fa-hand-paper mr-2"></i>Tenter la capture
                    <div class="text-sm opacity-80"><?= round($huntResult['capture_rate'] * 100, 1) ?>% de réussite</div>
                </button>
            </form>
            
            <form method="POST" action="<?= BASE_URL ?>chasse/kill" class="flex-1 max-w-xs">
                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-4 rounded-lg text-lg font-medium transition-colors">
                    <i class="fas fa-sword mr-2"></i>Éliminer
                    <div class="text-sm opacity-80">Or et ressources garantis</div>
                </button>
            </form>
        </div>
        
        <div class="mt-6 text-sm text-gray-500">
            <p><i class="fas fa-info-circle mr-1"></i>La capture peut échouer, mais l'élimination donne toujours des récompenses</p>
        </div>
    </div>
    
    <!-- Conseils -->
    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
        <h3 class="text-xl font-bold text-black mb-4">
            <i class="fas fa-lightbulb mr-2"></i>Conseils de chasse
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            <div class="space-y-2">
                <p><i class="fas fa-check text-green-600 mr-2"></i>Les créatures de niveau inférieur sont plus faciles à capturer</p>
                <p><i class="fas fa-check text-green-600 mr-2"></i>La capture donne de l'expérience de guilde</p>
            </div>
            <div class="space-y-2">
                <p><i class="fas fa-coins text-yellow-600 mr-2"></i>L'élimination donne de l'or et des ressources</p>
                <p><i class="fas fa-star text-purple-600 mr-2"></i>Les créatures rares valent plus d'expérience</p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>