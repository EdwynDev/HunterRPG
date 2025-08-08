<?php
$title = 'Chasse - Monster Hunter RPG';
ob_start();
?>

<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-black mb-4">
            <i class="fas fa-crosshairs mr-2"></i>Zone de chasse
        </h1>
        <p class="text-gray-600 text-lg">Partez à la recherche de créatures mystérieuses dans les terres sauvages</p>
    </div>
    
    <!-- Stats du joueur -->
    <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
        <h2 class="text-2xl font-bold mb-6 text-black">
            <i class="fas fa-chart-bar mr-2"></i>Statistiques de chasse
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-black mb-1"><?= $stats['total_captures'] ?></div>
                <div class="text-gray-500 text-sm">Captures totales</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600 mb-1"><?= $stats['legendaires'] ?></div>
                <div class="text-gray-500 text-sm">Légendaires</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 mb-1"><?= $stats['epiques'] ?></div>
                <div class="text-gray-500 text-sm">Épiques</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 mb-1"><?= $stats['rares'] ?></div>
                <div class="text-gray-500 text-sm">Rares</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-red-600 mb-1"><?= $stats['boss_captures'] ?></div>
                <div class="text-gray-500 text-sm">Boss capturés</div>
            </div>
        </div>
    </div>
    
    <!-- Zone de chasse principale -->
    <div class="bg-gray-50 rounded-2xl p-12 border border-gray-200 text-center card-hover">
        <div class="mb-8">
            <div class="text-6xl mb-4">🌲</div>
            <h2 class="text-3xl font-bold text-black mb-4">Forêt mystérieuse</h2>
            <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                Une forêt dense où rôdent des créatures de toutes sortes. 
                Préparez-vous à affronter l'inconnu et à découvrir des trésors cachés !
            </p>
        </div>
        
        <form method="POST" action="<?= BASE_URL ?>chasse/hunt">
            <button type="submit" 
                    class="btn-primary text-white px-12 py-6 rounded-2xl text-2xl font-bold">
                <i class="fas fa-search mr-3"></i>Partir en chasse
            </button>
        </form>
        
        <div class="mt-8 text-sm text-gray-500">
            <p><i class="fas fa-info-circle mr-1"></i>Conseil : Votre niveau influence les créatures que vous rencontrez</p>
        </div>
    </div>
    
    <!-- Informations sur les probabilités -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
            <h3 class="text-xl font-bold text-black mb-4">
                <i class="fas fa-dice mr-2"></i>Probabilités de rareté
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="rarity-commun font-medium">Commun</span>
                    <span class="text-gray-600 font-bold">50%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="rarity-peu_commun font-medium">Peu commun</span>
                    <span class="text-gray-600 font-bold">30%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="rarity-rare font-medium">Rare</span>
                    <span class="text-gray-600 font-bold">15%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="rarity-epique font-medium">Épique</span>
                    <span class="text-gray-600 font-bold">4%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="rarity-legendaire font-medium">Légendaire</span>
                    <span class="text-gray-600 font-bold">1%</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
            <h3 class="text-xl font-bold text-black mb-4">
                <i class="fas fa-star mr-2"></i>Statuts des créatures
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="status-normal font-medium">Normal (×1.0)</span>
                    <span class="text-gray-600 font-bold">70%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="status-elite font-medium">Élite (×1.2)</span>
                    <span class="text-gray-600 font-bold">20%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="status-alpha font-medium">Alpha (×1.5)</span>
                    <span class="text-gray-600 font-bold">9%</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <span class="status-boss font-medium">Boss (×2.0)</span>
                    <span class="text-gray-600 font-bold">1%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>