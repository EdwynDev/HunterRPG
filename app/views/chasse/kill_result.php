<?php
$title = 'Créature éliminée - Monster Hunter RPG';
ob_start();
?>

<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <div class="text-center">
        <div class="text-8xl mb-4">⚔️</div>
        <h1 class="text-4xl font-bold text-red-600 mb-4">
            <i class="fas fa-skull mr-2"></i>Créature éliminée
        </h1>
        <p class="text-gray-600 text-lg">Vous avez vaincu la créature et récupéré des ressources précieuses !</p>
    </div>
    
    <div class="bg-white rounded-2xl p-8 border border-red-200 text-center card-hover">
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
        
        <div class="bg-yellow-50 rounded-lg p-6 mb-6 border border-yellow-200">
            <h3 class="text-xl font-bold text-yellow-700 mb-4">Butin récupéré</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center p-4 bg-white rounded-lg border border-yellow-100">
                    <div class="text-3xl font-bold text-yellow-600 mb-1">+<?= $rewards['gold'] ?></div>
                    <div class="text-gray-500 text-sm">Or</div>
                </div>
                <div class="text-center p-4 bg-white rounded-lg border border-yellow-100">
                    <div class="text-3xl font-bold text-green-600 mb-1"><?= count($rewards['resources']) ?></div>
                    <div class="text-gray-500 text-sm">Ressources</div>
                </div>
            </div>
            
            <?php if (!empty($rewards['resources'])): ?>
            <div class="mt-4">
                <h4 class="font-semibold text-gray-700 mb-2">Ressources obtenues :</h4>
                <div class="flex flex-wrap justify-center gap-2">
                    <?php foreach ($rewards['resources'] as $resource): ?>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-leaf mr-1"></i><?= htmlspecialchars($resource['nom']) ?> x<?= $resource['quantite'] ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="mt-4 text-gray-600">
                <p>Aucune ressource spéciale cette fois-ci, mais vous avez gagné de l'or !</p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= BASE_URL ?>chasse" 
               class="btn-primary text-white px-8 py-3 rounded-lg font-medium">
                <i class="fas fa-redo mr-2"></i>Nouvelle chasse
            </a>
            <a href="<?= BASE_URL ?>craft" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-hammer mr-2"></i>Artisanat
            </a>
            <a href="<?= BASE_URL ?>" 
               class="btn-secondary text-gray-700 px-8 py-3 rounded-lg font-medium">
                <i class="fas fa-home mr-2"></i>Retour à l'accueil
            </a>
        </div>
    </div>
    
    <!-- Informations sur les ressources -->
    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
        <h3 class="text-xl font-bold text-black mb-4">
            <i class="fas fa-info-circle mr-2"></i>À propos des ressources
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
            <div class="flex items-start space-x-3">
                <i class="fas fa-hammer text-black mt-1"></i>
                <div>
                    <p class="font-medium text-black">Artisanat</p>
                    <p>Utilisez vos ressources pour crafter des objets puissants</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <i class="fas fa-exchange-alt text-black mt-1"></i>
                <div>
                    <p class="font-medium text-black">Échanges</p>
                    <p>Échangez avec d'autres joueurs pour obtenir ce dont vous avez besoin</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <i class="fas fa-egg text-black mt-1"></i>
                <div>
                    <p class="font-medium text-black">Œufs rares</p>
                    <p>Les œufs peuvent éclore en créatures si vous échouez une capture</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>