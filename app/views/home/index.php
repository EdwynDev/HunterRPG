<?php
$title = 'Accueil - Monster Hunter RPG';
ob_start();
?>

<div class="space-y-12 animate-fade-in">
    <!-- Hero Section -->
    <div class="text-center py-16">
        <h1 class="text-6xl font-bold mb-6 text-black">
            Monster Hunter RPG
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
            Partez à l'aventure dans un monde mystérieux peuplé de créatures fantastiques. 
            Chassez, capturez et collectionnez des monstres légendaires dans cette expérience RPG unique.
        </p>
        
        <?php if (!$currentPlayer): ?>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= BASE_URL ?>auth/register" class="btn-primary text-white px-8 py-4 rounded-lg text-lg font-medium">
                <i class="fas fa-play mr-2"></i>Commencer l'aventure
            </a>
            <a href="<?= BASE_URL ?>auth/login" class="btn-secondary text-gray-700 px-8 py-4 rounded-lg text-lg font-medium">
                <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
            </a>
        </div>
        <?php else: ?>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= BASE_URL ?>chasse" class="btn-primary text-white px-8 py-4 rounded-lg text-lg font-medium">
                <i class="fas fa-crosshairs mr-2"></i>Partir en chasse
            </a>
            <a href="<?= BASE_URL ?>collection" class="btn-secondary text-gray-700 px-8 py-4 rounded-lg text-lg font-medium">
                <i class="fas fa-book mr-2"></i>Ma collection
            </a>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Stats Section -->
    <?php if ($currentPlayer): ?>
    <div class="bg-gray-50 rounded-2xl p-8 border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-black">
            <i class="fas fa-user-astronaut mr-2"></i>Profil d'aventurier
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-black mb-1"><?= $currentPlayer['niveau'] ?></div>
                <div class="text-gray-500 text-sm">Niveau</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600 mb-1"><?= number_format($currentPlayer['ors']) ?></div>
                <div class="text-gray-500 text-sm">Or</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 mb-1"><?= htmlspecialchars($currentPlayer['rang']) ?></div>
                <div class="text-gray-500 text-sm">Rang</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 mb-1"><?= number_format($currentPlayer['exp_guilde']) ?></div>
                <div class="text-gray-500 text-sm">EXP Guilde</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Bestiaire -->
        <div class="bg-white rounded-2xl p-8 border border-gray-200 card-hover">
            <h2 class="text-2xl font-bold mb-6 text-black">
                <i class="fas fa-dragon mr-2"></i>Bestiaire
            </h2>
            <div class="space-y-4">
                <?php foreach ($creatures as $creature): ?>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                    <div>
                        <h3 class="font-semibold rarity-<?= $creature['rarete'] ?> text-lg">
                            <?= htmlspecialchars($creature['nom']) ?>
                        </h3>
                        <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($creature['description']) ?></p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm rarity-<?= $creature['rarete'] ?> font-semibold">
                            <?= ucfirst(str_replace('_', ' ', $creature['rarete'])) ?>
                        </div>
                        <div class="text-xs text-gray-500">Niv. max: <?= $creature['niveau_max'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Enclos publics -->
        <div class="bg-white rounded-2xl p-8 border border-gray-200 card-hover">
            <h2 class="text-2xl font-bold mb-6 text-black">
                <i class="fas fa-eye mr-2"></i>Enclos publics
            </h2>
            <?php if (empty($publicEnclos)): ?>
            <div class="text-center py-8">
                <div class="text-4xl mb-4">🏛️</div>
                <p class="text-gray-500">Aucune créature exposée pour le moment.</p>
            </div>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach (array_slice($publicEnclos, 0, 5) as $capture): ?>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100 hover:border-gray-200 transition-colors">
                    <div>
                        <h3 class="font-semibold rarity-<?= $capture['rarete'] ?>">
                            <?= htmlspecialchars($capture['nom_personnalise'] ?: $capture['creature_nom']) ?>
                        </h3>
                        <p class="text-sm text-gray-600">
                            Par <?= htmlspecialchars($capture['proprietaire']) ?> 
                            • <span class="status-<?= strtolower(str_replace('é', 'e', $capture['statut_nom'])) ?>"><?= $capture['statut_nom'] ?></span>
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-black">Niv. <?= $capture['niveau'] ?></div>
                        <div class="text-xs text-gray-500"><?= $capture['enclos_nom'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="text-center pt-4">
                    <a href="<?= BASE_URL ?>enclos" class="text-black hover:text-gray-600 transition-colors font-medium">
                        <i class="fas fa-arrow-right mr-1"></i>Voir tous les enclos
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Top Players -->
    <?php if (!empty($topPlayers)): ?>
    <div class="bg-white rounded-2xl p-8 border border-gray-200 card-hover">
        <h2 class="text-2xl font-bold mb-6 text-black">
            <i class="fas fa-trophy mr-2"></i>Meilleurs aventuriers
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <?php foreach ($topPlayers as $index => $player): ?>
            <div class="text-center p-6 bg-gray-50 rounded-lg border border-gray-100">
                <div class="text-2xl mb-2">
                    <?php if ($index === 0): ?>
                        <i class="fas fa-crown text-yellow-500"></i>
                    <?php elseif ($index === 1): ?>
                        <i class="fas fa-medal text-gray-400"></i>
                    <?php elseif ($index === 2): ?>
                        <i class="fas fa-medal text-yellow-600"></i>
                    <?php else: ?>
                        <i class="fas fa-user text-gray-400"></i>
                    <?php endif; ?>
                </div>
                <h3 class="font-semibold text-black"><?= htmlspecialchars($player['pseudo']) ?></h3>
                <p class="text-sm text-gray-600">Rang <?= htmlspecialchars($player['rang']) ?></p>
                <p class="text-xs text-gray-500"><?= $player['captures_count'] ?> captures</p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>