<?php
$title = 'Chasse - Monster Hunter RPG';
ob_start();
?>

<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-cyber-blue mb-4">
            <i class="fas fa-crosshairs mr-2"></i>Zone de chasse
        </h1>
        <p class="text-gray-300 text-lg">Partez à la recherche de créatures mystérieuses dans les terres sauvages</p>
    </div>
    
    <!-- Stats du joueur -->
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
        <h2 class="text-2xl font-bold mb-6 text-cyber-blue">
            <i class="fas fa-chart-bar mr-2"></i>Statistiques de chasse
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-cyber-blue"><?= $stats['total_captures'] ?></div>
                <div class="text-gray-400">Captures totales</div>
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
                <div class="text-gray-400">Boss capturés</div>
            </div>
        </div>
    </div>
    
    <!-- Zone de chasse principale -->
    <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-8 border border-cyber-blue/30 text-center">
        <div class="mb-8">
            <div class="text-6xl mb-4 animate-float">🌲</div>
            <h2 class="text-3xl font-bold text-cyber-blue mb-4">Forêt mystérieuse</h2>
            <p class="text-gray-300 text-lg mb-8">
                Une forêt dense où rôdent des créatures de toutes sortes. 
                Préparez-vous à affronter l'inconnu !
            </p>
        </div>
        
        <form method="POST" action="<?= BASE_URL ?>chasse/hunt">
            <button type="submit" 
                    class="bg-gradient-to-r from-cyber-blue to-cyber-purple hover:from-cyber-purple hover:to-cyber-pink px-12 py-6 rounded-2xl text-2xl font-bold text-dark-bg transition-all transform hover:scale-105 animate-glow">
                <i class="fas fa-search mr-3"></i>Partir en chasse
            </button>
        </form>
        
        <div class="mt-8 text-sm text-gray-400">
            <p><i class="fas fa-info-circle mr-1"></i>Conseil : Votre niveau influence les créatures que vous rencontrez</p>
        </div>
    </div>
    
    <!-- Informations sur les probabilités -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
            <h3 class="text-xl font-bold text-cyber-blue mb-4">
                <i class="fas fa-dice mr-2"></i>Probabilités de rareté
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="rarity-commun">Commun</span>
                    <span class="text-gray-400">50%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="rarity-peu_commun">Peu commun</span>
                    <span class="text-gray-400">30%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="rarity-rare">Rare</span>
                    <span class="text-gray-400">15%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="rarity-epique">Épique</span>
                    <span class="text-gray-400">4%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="rarity-legendaire">Légendaire</span>
                    <span class="text-gray-400">1%</span>
                </div>
            </div>
        </div>
        
        <div class="bg-dark-card/50 backdrop-blur-sm rounded-2xl p-6 border border-cyber-blue/30">
            <h3 class="text-xl font-bold text-cyber-blue mb-4">
                <i class="fas fa-star mr-2"></i>Statuts des créatures
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="status-normal">Normal (×1.0)</span>
                    <span class="text-gray-400">70%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="status-elite">Élite (×1.2)</span>
                    <span class="text-gray-400">20%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="status-alpha">Alpha (×1.5)</span>
                    <span class="text-gray-400">9%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="status-boss">Boss (×2.0)</span>
                    <span class="text-gray-400">1%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>