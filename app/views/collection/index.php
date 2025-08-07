<?php
$title = 'Ma Collection - Monster Hunter RPG';
ob_start();
?>

<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-cyber-blue mb-4">
            <i class="fas fa-book mr-2"></i>Ma Collection
        </h1>
        <p class="text-gray-300 text-lg">Découvrez toutes les créatures que vous avez capturées</p>
    </div>
    
    <!-- Statistiques -->
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
        <h2 class="text-2xl font-bold mb-6 text-cyber-blue">
            <i class="fas fa-chart-pie mr-2"></i>Statistiques de collection
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-cyber-blue"><?= $stats['total_captures'] ?></div>
                <div class="text-gray-400">Total</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-400"><?= $stats['legendaires'] ?></div>
                <div class="text-gray-400">Légendaires</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-400"><?= $stats['epiques'] ?></div>
                <div class="text-gray-400">Épiques</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-400"><?= $stats['rares'] ?></div>
                <div class="text-gray-400">Rares</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-red-400"><?= $stats['boss_captures'] ?></div>
                <div class="text-gray-400">Boss</div>
            </div>
        </div>
    </div>
    
    <!-- Collection -->
    <?php if (empty($captures)): ?>
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-12 border border-cyber-blue/30 text-center">
        <div class="text-6xl mb-4">📖</div>
        <h2 class="text-2xl font-bold text-gray-400 mb-4">Collection vide</h2>
        <p class="text-gray-500 mb-6">Vous n'avez pas encore capturé de créatures.</p>
        <a href="<?= BASE_URL ?>chasse" 
           class="bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink px-8 py-3 rounded-lg font-semibold text-dark-bg transition-all">
            <i class="fas fa-crosshairs mr-2"></i>Partir en chasse
        </a>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($captures as $capture): ?>
        <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-cyber-blue/50 transition-all transform hover:scale-105">
            <div class="text-center mb-4">
                <div class="text-4xl mb-2">
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
                
                <h3 class="text-xl font-bold rarity-<?= $capture['rarete'] ?> mb-1">
                    <?= htmlspecialchars($capture['nom_personnalise'] ?: $capture['creature_nom']) ?>
                </h3>
                
                <?php if ($capture['nom_personnalise']): ?>
                <p class="text-sm text-gray-400">(<?= htmlspecialchars($capture['creature_nom']) ?>)</p>
                <?php endif; ?>
            </div>
            
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">Niveau :</span>
                    <span class="text-cyber-blue font-semibold"><?= $capture['niveau'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Statut :</span>
                    <span class="status-<?= strtolower(str_replace('é', 'e', $capture['statut_nom'])) ?> font-semibold">
                        <?= $capture['statut_nom'] ?>
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Rareté :</span>
                    <span class="rarity-<?= $capture['rarete'] ?> font-semibold">
                        <?= ucfirst(str_replace('_', ' ', $capture['rarete'])) ?>
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Capturé le :</span>
                    <span class="text-gray-300"><?= date('d/m/Y', strtotime($capture['date_capture'])) ?></span>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-700">
                <a href="<?= BASE_URL ?>collection/view/<?= $capture['id'] ?>" 
                   class="block w-full text-center bg-cyber-blue/20 hover:bg-cyber-blue/30 py-2 rounded-lg transition-colors">
                    <i class="fas fa-eye mr-1"></i>Voir les détails
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>