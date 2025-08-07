<?php
$title = htmlspecialchars($capture['nom_personnalise'] ?: $capture['creature_nom']) . ' - Collection';
ob_start();
?>

<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="text-center">
        <a href="<?= BASE_URL ?>collection" class="text-cyber-blue hover:text-cyber-purple transition-colors mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la collection
        </a>
        <h1 class="text-4xl font-bold rarity-<?= $capture['rarete'] ?> mb-4">
            <?= htmlspecialchars($capture['nom_personnalise'] ?: $capture['creature_nom']) ?>
        </h1>
        <?php if ($capture['nom_personnalise']): ?>
        <p class="text-gray-400 text-lg">(<?= htmlspecialchars($capture['creature_nom']) ?>)</p>
        <?php endif; ?>
    </div>
    
    <!-- Créature principale -->
    <div class="bg-dark-card/80 backdrop-blur-sm rounded-2xl p-8 border border-cyber-blue/30">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image/Emoji de la créature -->
            <div class="text-center">
                <div class="text-9xl mb-6 animate-float">
                    <?php
                    $creatureEmojis = [
                        'Gobelin' => '👹',
                        'Loup' => '🐺',
                        'Griffon' => '🦅',
                        'Dragon' => '🐉',
                        'Phénix' => '🔥'
                    ];
                    echo $creatureEmojis[$capture['creature_nom']] ?? '👾';
                    ?>
                </div>
                
                <div class="space-y-2">
                    <div class="text-2xl font-bold status-<?= strtolower(str_replace('é', 'e', $capture['statut_nom'])) ?>">
                        <?= $capture['statut_nom'] ?>
                    </div>
                    <div class="text-lg rarity-<?= $capture['rarete'] ?>">
                        <?= ucfirst(str_replace('_', ' ', $capture['rarete'])) ?>
                    </div>
                </div>
            </div>
            
            <!-- Informations détaillées -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-xl font-bold text-cyber-blue mb-4">Informations</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-dark-accent/50 rounded-lg">
                            <span class="text-gray-400">Niveau</span>
                            <span class="text-2xl font-bold text-cyber-blue"><?= $capture['niveau'] ?></span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-dark-accent/50 rounded-lg">
                            <span class="text-gray-400">Puissance</span>
                            <span class="text-xl font-bold text-green-400">
                                <?= intval($capture['niveau'] * 10 * $capture['multiplicateur_stats']) ?>
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-dark-accent/50 rounded-lg">
                            <span class="text-gray-400">Multiplicateur</span>
                            <span class="text-xl font-bold text-yellow-400">×<?= $capture['multiplicateur_stats'] ?></span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-dark-accent/50 rounded-lg">
                            <span class="text-gray-400">Propriétaire</span>
                            <span class="text-lg font-semibold text-cyber-purple"><?= htmlspecialchars($capture['proprietaire']) ?></span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-xl font-bold text-cyber-blue mb-4">Capture</h3>
                    <div class="p-3 bg-dark-accent/50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Date de capture</span>
                            <span class="text-lg text-gray-300"><?= date('d/m/Y à H:i', strtotime($capture['date_capture'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Description -->
        <div class="mt-8 p-6 bg-dark-accent/30 rounded-lg border border-gray-700/50">
            <h3 class="text-xl font-bold text-cyber-blue mb-3">Description</h3>
            <p class="text-gray-300 leading-relaxed"><?= htmlspecialchars($capture['description']) ?></p>
        </div>
    </div>
    
    <!-- Actions (si c'est la créature du joueur) -->
    <?php if ($capture['joueur_id'] == $currentPlayer['id']): ?>
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
        <h3 class="text-xl font-bold text-cyber-blue mb-4">
            <i class="fas fa-cogs mr-2"></i>Actions
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button class="bg-blue-600 hover:bg-blue-700 py-3 rounded-lg transition-colors" disabled>
                <i class="fas fa-edit mr-2"></i>Renommer
                <div class="text-xs opacity-70">Bientôt disponible</div>
            </button>
            <button class="bg-green-600 hover:bg-green-700 py-3 rounded-lg transition-colors" disabled>
                <i class="fas fa-home mr-2"></i>Mettre en enclos
                <div class="text-xs opacity-70">Bientôt disponible</div>
            </button>
            <button class="bg-purple-600 hover:bg-purple-700 py-3 rounded-lg transition-colors" disabled>
                <i class="fas fa-heart mr-2"></i>Reproduction
                <div class="text-xs opacity-70">Bientôt disponible</div>
            </button>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Statistiques de rareté -->
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
        <h3 class="text-xl font-bold text-cyber-blue mb-4">
            <i class="fas fa-chart-bar mr-2"></i>Rareté et valeur
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold rarity-<?= $capture['rarete'] ?>">
                    <?php
                    $rarityPercentages = [
                        'commun' => '50%',
                        'peu_commun' => '30%',
                        'rare' => '15%',
                        'epique' => '4%',
                        'legendaire' => '1%'
                    ];
                    echo $rarityPercentages[$capture['rarete']];
                    ?>
                </div>
                <div class="text-gray-400">Chance d'apparition</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold status-<?= strtolower(str_replace('é', 'e', $capture['statut_nom'])) ?>">
                    <?php
                    $statusPercentages = [
                        'Normal' => '70%',
                        'Élite' => '20%',
                        'Alpha' => '9%',
                        'Boss' => '1%'
                    ];
                    echo $statusPercentages[$capture['statut_nom']];
                    ?>
                </div>
                <div class="text-gray-400">Chance de statut</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-400">
                    <?php
                    $baseValue = $capture['niveau'] * 100;
                    $rarityMultiplier = [
                        'commun' => 1,
                        'peu_commun' => 2,
                        'rare' => 4,
                        'epique' => 8,
                        'legendaire' => 16
                    ][$capture['rarete']];
                    $statusMultiplier = $capture['multiplicateur_stats'];
                    $totalValue = intval($baseValue * $rarityMultiplier * $statusMultiplier);
                    echo number_format($totalValue);
                    ?>
                </div>
                <div class="text-gray-400">Valeur estimée</div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>