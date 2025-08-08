<?php
$title = 'Artisanat - Monster Hunter RPG';
ob_start();
?>

<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-black mb-4">
            <i class="fas fa-hammer mr-2"></i>Atelier d'artisanat
        </h1>
        <p class="text-gray-600 text-lg">Transformez vos ressources en objets puissants</p>
    </div>
    
    <!-- Messages -->
    <?php if (isset($_SESSION['craft_success'])): ?>
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <p class="text-green-700"><i class="fas fa-check-circle mr-2"></i><?= htmlspecialchars($_SESSION['craft_success']) ?></p>
    </div>
    <?php unset($_SESSION['craft_success']); endif; ?>
    
    <?php if (isset($_SESSION['craft_error'])): ?>
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <p class="text-red-700"><i class="fas fa-exclamation-triangle mr-2"></i><?= htmlspecialchars($_SESSION['craft_error']) ?></p>
    </div>
    <?php unset($_SESSION['craft_error']); endif; ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Inventaire des ressources -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
                <h2 class="text-xl font-bold mb-6 text-black">
                    <i class="fas fa-box mr-2"></i>Inventaire
                </h2>
                
                <?php 
                $hasResources = false;
                foreach ($inventory as $resource) {
                    if ($resource['quantite'] > 0) {
                        $hasResources = true;
                        break;
                    }
                }
                ?>
                
                <?php if (!$hasResources): ?>
                <div class="text-center py-8">
                    <div class="text-4xl mb-4">📦</div>
                    <p class="text-gray-500">Aucune ressource</p>
                    <p class="text-sm text-gray-400 mt-2">Partez en chasse pour obtenir des ressources</p>
                </div>
                <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($inventory as $resource): ?>
                        <?php if ($resource['quantite'] > 0): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div>
                                <h3 class="font-medium text-black"><?= htmlspecialchars($resource['nom']) ?></h3>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars($resource['description']) ?></p>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-green-600"><?= $resource['quantite'] ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recettes -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
                <h2 class="text-xl font-bold mb-6 text-black">
                    <i class="fas fa-scroll mr-2"></i>Recettes disponibles
                </h2>
                
                <?php if (empty($recipes)): ?>
                <div class="text-center py-8">
                    <div class="text-4xl mb-4">📜</div>
                    <p class="text-gray-500">Aucune recette disponible</p>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($recipes as $recipe): ?>
                    <div class="border border-gray-200 rounded-lg p-6 <?= $recipe['can_craft'] ? 'bg-green-50 border-green-200' : 'bg-gray-50' ?>">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-black"><?= htmlspecialchars($recipe['nom']) ?></h3>
                                <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($recipe['description']) ?></p>
                            </div>
                            <?php if ($recipe['can_craft']): ?>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-check mr-1"></i>Possible
                            </span>
                            <?php else: ?>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-times mr-1"></i>Impossible
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Ingrédients requis :</h4>
                            <div class="space-y-1">
                                <?php foreach ($recipe['ingredients_parsed'] as $ingredient): ?>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600"><?= htmlspecialchars($ingredient['nom']) ?></span>
                                    <span class="font-medium"><?= $ingredient['quantite'] ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <?php if ($recipe['can_craft']): ?>
                        <form method="POST" action="<?= BASE_URL ?>craft/craft/<?= $recipe['id'] ?>">
                            <button type="submit" 
                                    class="w-full btn-primary text-white py-2 rounded-lg font-medium">
                                <i class="fas fa-hammer mr-2"></i>Crafter
                            </button>
                        </form>
                        <?php else: ?>
                        <button disabled 
                                class="w-full bg-gray-200 text-gray-500 py-2 rounded-lg font-medium cursor-not-allowed">
                            <i class="fas fa-ban mr-2"></i>Ressources insuffisantes
                        </button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Informations -->
    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
        <h3 class="text-lg font-bold text-black mb-4">
            <i class="fas fa-info-circle mr-2"></i>Comment obtenir des ressources ?
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
            <div class="flex items-start space-x-3">
                <i class="fas fa-crosshairs text-black mt-1"></i>
                <div>
                    <p class="font-medium text-black">Chasse</p>
                    <p>Éliminez des créatures pour obtenir leurs ressources spécifiques</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <i class="fas fa-percentage text-black mt-1"></i>
                <div>
                    <p class="font-medium text-black">Probabilités</p>
                    <p>Chaque créature a ses propres chances de drop pour différentes ressources</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <i class="fas fa-hammer text-black mt-1"></i>
                <div>
                    <p class="font-medium text-black">Artisanat</p>
                    <p>Combinez vos ressources pour créer des objets puissants</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>