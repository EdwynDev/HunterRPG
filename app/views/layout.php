<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Monster Hunter RPG' ?></title>
    
    <!-- Google Fonts - Electrolize -->
    <link href="https://fonts.googleapis.com/css2?family=Electrolize:wght@400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'electrolize': ['Electrolize', 'monospace'],
                    },
                    colors: {
                        'gray-50': '#fafafa',
                        'gray-100': '#f5f5f5',
                        'gray-200': '#e5e5e5',
                        'gray-300': '#d4d4d4',
                        'gray-400': '#a3a3a3',
                        'gray-500': '#737373',
                        'gray-600': '#525252',
                        'gray-700': '#404040',
                        'gray-800': '#262626',
                        'gray-900': '#171717',
                        'gray-950': '#0a0a0a',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'pulse-subtle': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Electrolize', monospace;
        }
        
        .rarity-commun { color: #737373; }
        .rarity-peu_commun { color: #10b981; }
        .rarity-rare { color: #3b82f6; }
        .rarity-epique { color: #8b5cf6; }
        .rarity-legendaire { color: #f59e0b; }
        
        .status-normal { color: #737373; }
        .status-elite { color: #10b981; }
        .status-alpha { color: #f59e0b; }
        .status-boss { color: #ef4444; }
        
        .card-hover {
            transition: all 0.2s ease-in-out;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #000000 0%, #404040 100%);
            transition: all 0.2s ease-in-out;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #262626 0%, #525252 100%);
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            border: 1px solid #d4d4d4;
            transition: all 0.2s ease-in-out;
        }
        
        .btn-secondary:hover {
            background-color: #f5f5f5;
            border-color: #a3a3a3;
        }
    </style>
</head>
<body class="bg-white text-gray-900 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 backdrop-blur-sm bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="<?= BASE_URL ?>" class="text-2xl font-bold text-black hover:text-gray-700 transition-colors">
                        <i class="fas fa-dragon mr-2"></i>Monster Hunter
                    </a>
                    
                    <?php if (isset($_SESSION['joueur_id'])): ?>
                    <div class="hidden md:flex space-x-6">
                        <a href="<?= BASE_URL ?>chasse" class="text-gray-600 hover:text-black transition-colors font-medium">
                            <i class="fas fa-crosshairs mr-1"></i>Chasse
                        </a>
                        <a href="<?= BASE_URL ?>collection" class="text-gray-600 hover:text-black transition-colors font-medium">
                            <i class="fas fa-book mr-1"></i>Collection
                        </a>
                        <a href="<?= BASE_URL ?>craft" class="text-gray-600 hover:text-black transition-colors font-medium">
                            <i class="fas fa-hammer mr-1"></i>Artisanat
                        </a>
                        <a href="<?= BASE_URL ?>enclos" class="text-gray-600 hover:text-black transition-colors font-medium">
                            <i class="fas fa-eye mr-1"></i>Enclos
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['joueur_id'])): ?>
                        <?php $currentPlayer = $currentPlayer ?? null; ?>
                        <?php if ($currentPlayer): ?>
                        <div class="hidden md:flex items-center space-x-4 text-sm">
                            <span class="text-black font-medium">
                                <i class="fas fa-user mr-1"></i><?= htmlspecialchars($currentPlayer['pseudo']) ?>
                            </span>
                            <span class="text-yellow-600 font-medium">
                                <i class="fas fa-coins mr-1"></i><?= number_format($currentPlayer['ors']) ?>
                            </span>
                            <span class="text-purple-600 font-medium">
                                <i class="fas fa-star mr-1"></i><?= htmlspecialchars($currentPlayer['rang']) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>auth/logout" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i>Déconnexion
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>auth/login" class="btn-primary text-white px-6 py-2 rounded-lg font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i>Connexion
                        </a>
                        <a href="<?= BASE_URL ?>auth/register" class="btn-secondary text-gray-700 px-6 py-2 rounded-lg font-medium">
                            <i class="fas fa-user-plus mr-1"></i>Inscription
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if (isset($content)) echo $content; ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-500">
                <p>&copy; 2025 Monster Hunter RPG. Tous droits réservés.</p>
                <p class="mt-2 text-sm">Chassez, capturez, collectionnez !</p>
            </div>
        </div>
    </footer>
</body>
</html>