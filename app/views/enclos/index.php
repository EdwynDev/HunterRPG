<?php
$title = 'Enclos Publics - Monster Hunter RPG';
ob_start();
?>

<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-cyber-blue mb-4">
            <i class="fas fa-eye mr-2"></i>Enclos Publics
        </h1>
        <p class="text-gray-300 text-lg">Découvrez les créatures que les autres aventuriers ont choisi d'exposer</p>
    </div>
    
    <!-- Enclos publics -->
    <?php if (empty($publicEnclos)): ?>
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-12 border border-cyber-blue/30 text-center">
        <div class="text-6xl mb-4">🏛️</div>
        <h2 class="text-2xl font-bold text-gray-400 mb-4">Aucun enclos public</h2>
        <p class="text-gray-500 mb-6">Aucun aventurier n'a encore exposé ses créatures publiquement.</p>
        <?php if ($currentPlayer): ?>
        <a href="<?= BASE_URL ?>collection" 
           class="bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink px-8 py-3 rounded-lg font-semibold text-dark-bg transition-all">
            <i class="fas fa-book mr-2"></i>Voir ma collection
        </a>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($publicEnclos as $capture): ?>
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
                
                <p class="text-sm text-cyber-purple mt-2">
                    <i class="fas fa-user mr-1"></i>Par <?= htmlspecialchars($capture['proprietaire']) ?>
                </p>
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
                    <span class="text-gray-400">Enclos :</span>
                    <span class="text-gray-300"><?= htmlspecialchars($capture['enclos_nom']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Exposé le :</span>
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
    
    <!-- Informations -->
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
        <h3 class="text-xl font-bold text-cyber-blue mb-4">
            <i class="fas fa-info-circle mr-2"></i>À propos des enclos publics
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-300">
            <div>
                <h4 class="font-semibold text-cyber-purple mb-2">Qu'est-ce qu'un enclos public ?</h4>
                <p class="text-sm">
                    Les enclos publics permettent aux aventuriers de montrer leurs plus belles créatures 
                    à la communauté. C'est un moyen de partager ses trophées et d'inspirer les autres chasseurs.
                </p>
            </div>
            <div>
                <h4 class="font-semibold text-cyber-purple mb-2">Comment exposer mes créatures ?</h4>
                <p class="text-sm">
                    Cette fonctionnalité sera bientôt disponible ! Vous pourrez créer vos propres enclos 
                    et choisir quelles créatures exposer au public.
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>