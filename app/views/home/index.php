<?php
$title = 'Accueil - Monster Hunter RPG';
ob_start();
?>

<div class="space-y-8">
    <!-- Hero Section -->
    <div class="text-center py-16 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-cyber-blue/10 to-cyber-purple/10 rounded-3xl"></div>
        <div class="relative z-10">
            <h1 class="text-6xl font-bold mb-6 bg-gradient-to-r from-cyber-blue to-cyber-purple bg-clip-text text-transparent animate-glow">
                Monster Hunter RPG
            </h1>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Partez à l'aventure dans un monde mystérieux peuplé de créatures fantastiques. 
                Chassez, capturez et collectionnez des monstres légendaires !
            </p>
            
            <?php if (!$currentPlayer): ?>
            <div class="space-x-4">
                <a href="<?= BASE_URL ?>auth/register" class="bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink px-8 py-4 rounded-lg text-lg font-semibold text-dark-bg transition-all transform hover:scale-105">
                    <i class="fas fa-play mr-2"></i>Commencer l'aventure
                </a>
                <a href="<?= BASE_URL ?>auth/login" class="border-2 border-cyber-blue hover:bg-cyber-blue hover:text-dark-bg px-8 py-4 rounded-lg text-lg font-semibold transition-all">
                    <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                </a>
            </div>
            <?php else: ?>
            <div class="space-x-4">
                <a href="<?= BASE_URL ?>chasse" class="bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink px-8 py-4 rounded-lg text-lg font-semibold text-dark-bg transition-all transform hover:scale-105">
                    <i class="fas fa-crosshairs mr-2"></i>Partir en chasse
                </a>
                <a href="<?= BASE_URL ?>collection" class="border-2 border-cyber-blue hover:bg-cyber-blue hover:text-dark-bg px-8 py-4 rounded-lg text-lg font-semibold transition-all">
                    <i class="fas fa-book mr-2"></i>Ma collection
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Stats Section -->
    <?php if ($currentPlayer): ?>
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
        <h2 class="text-2xl font-bold mb-6 text-cyber-blue">
            <i class="fas fa-user-astronaut mr-2"></i>Profil d'aventurier
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-cyber-blue"><?= $currentPlayer['niveau'] ?></div>
                <div class="text-gray-400">Niveau</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-400"><?= number_format($currentPlayer['ors']) ?></div>
                <div class="text-gray-400">Or</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-cyber-purple"><?= htmlspecialchars($currentPlayer['rang']) ?></div>
                <div class="text-gray-400">Rang</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-400"><?= number_format($currentPlayer['exp_guilde']) ?></div>
                <div class="text-gray-400">EXP Guilde</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Bestiaire -->
        <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
            <h2 class="text-2xl font-bold mb-6 text-cyber-blue">
                <i class="fas fa-dragon mr-2"></i>Bestiaire
            </h2>
            <div class="space-y-4">
                <?php foreach ($creatures as $creature): ?>
                <div class="flex items-center justify-between p-4 bg-dark-accent/50 rounded-lg border border-gray-700/50 hover:border-cyber-blue/50 transition-colors">
                    <div>
                        <h3 class="font-semibold rarity-<?= $creature['rarete'] ?>">
                            <?= htmlspecialchars($creature['nom']) ?>
                        </h3>
                        <p class="text-sm text-gray-400"><?= htmlspecialchars($creature['description']) ?></p>
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
        <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
            <h2 class="text-2xl font-bold mb-6 text-cyber-blue">
                <i class="fas fa-eye mr-2"></i>Enclos publics
            </h2>
            <?php if (empty($publicEnclos)): ?>
            <p class="text-gray-400 text-center py-8">Aucune créature exposée pour le moment.</p>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach (array_slice($publicEnclos, 0, 5) as $capture): ?>
                <div class="flex items-center justify-between p-4 bg-dark-accent/50 rounded-lg border border-gray-700/50 hover:border-cyber-blue/50 transition-colors">
                    <div>
                        <h3 class="font-semibold rarity-<?= $capture['rarete'] ?>">
                            <?= htmlspecialchars($capture['nom_personnalise'] ?: $capture['creature_nom']) ?>
                        </h3>
                        <p class="text-sm text-gray-400">
                            Par <?= htmlspecialchars($capture['proprietaire']) ?> 
                            • <span class="status-<?= strtolower(str_replace('é', 'e', $capture['statut_nom'])) ?>"><?= $capture['statut_nom'] ?></span>
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-cyber-blue">Niv. <?= $capture['niveau'] ?></div>
                        <div class="text-xs text-gray-500"><?= $capture['enclos_nom'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="text-center pt-4">
                    <a href="<?= BASE_URL ?>enclos" class="text-cyber-blue hover:text-cyber-purple transition-colors">
                        <i class="fas fa-arrow-right mr-1"></i>Voir tous les enclos
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Top Players -->
    <?php if (!empty($topPlayers)): ?>
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
        <h2 class="text-2xl font-bold mb-6 text-cyber-blue">
            <i class="fas fa-trophy mr-2"></i>Meilleurs aventuriers
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <?php foreach ($topPlayers as $index => $player): ?>
            <div class="text-center p-4 bg-dark-accent/50 rounded-lg border border-gray-700/50">
                <div class="text-2xl mb-2">
                    <?php if ($index === 0): ?>
                        <i class="fas fa-crown text-yellow-400"></i>
                    <?php elseif ($index === 1): ?>
                        <i class="fas fa-medal text-gray-300"></i>
                    <?php elseif ($index === 2): ?>
                        <i class="fas fa-medal text-yellow-600"></i>
                    <?php else: ?>
                        <i class="fas fa-user text-gray-500"></i>
                    <?php endif; ?>
                </div>
                <h3 class="font-semibold text-cyber-blue"><?= htmlspecialchars($player['pseudo']) ?></h3>
                <p class="text-sm text-gray-400">Rang <?= htmlspecialchars($player['rang']) ?></p>
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