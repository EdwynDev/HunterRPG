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
    
    <!-- Three.js pour les effets 3D -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'electrolize': ['Electrolize', 'monospace'],
                    },
                    colors: {
                        'cyber-blue': '#00f5ff',
                        'cyber-purple': '#8b5cf6',
                        'cyber-pink': '#ec4899',
                        'dark-bg': '#0f0f23',
                        'dark-card': '#1a1a2e',
                        'dark-accent': '#16213e',
                    },
                    animation: {
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        glow: {
                            '0%': { boxShadow: '0 0 5px #00f5ff, 0 0 10px #00f5ff, 0 0 15px #00f5ff' },
                            '100%': { boxShadow: '0 0 10px #00f5ff, 0 0 20px #00f5ff, 0 0 30px #00f5ff' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Electrolize', monospace;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
        }
        
        .cyber-border {
            border: 2px solid transparent;
            background: linear-gradient(45deg, #00f5ff, #8b5cf6, #ec4899) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }
        
        .rarity-commun { color: #9ca3af; }
        .rarity-peu_commun { color: #10b981; }
        .rarity-rare { color: #3b82f6; }
        .rarity-epique { color: #8b5cf6; }
        .rarity-legendaire { color: #f59e0b; }
        
        .status-normal { color: #9ca3af; }
        .status-elite { color: #10b981; }
        .status-alpha { color: #f59e0b; }
        .status-boss { color: #ef4444; }
        
        .particle-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<body class="text-white">
    <!-- Particle Background -->
    <canvas id="particle-canvas" class="particle-bg"></canvas>
    
    <!-- Navigation -->
    <nav class="bg-dark-card/80 backdrop-blur-sm border-b border-cyber-blue/30 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="<?= BASE_URL ?>" class="text-2xl font-bold text-cyber-blue hover:text-cyber-purple transition-colors">
                        <i class="fas fa-dragon mr-2"></i>Monster Hunter RPG
                    </a>
                    
                    <?php if (isset($_SESSION['joueur_id'])): ?>
                    <div class="hidden md:flex space-x-6">
                        <a href="<?= BASE_URL ?>chasse" class="hover:text-cyber-blue transition-colors">
                            <i class="fas fa-crosshairs mr-1"></i>Chasse
                        </a>
                        <a href="<?= BASE_URL ?>collection" class="hover:text-cyber-blue transition-colors">
                            <i class="fas fa-book mr-1"></i>Collection
                        </a>
                        <a href="<?= BASE_URL ?>enclos" class="hover:text-cyber-blue transition-colors">
                            <i class="fas fa-eye mr-1"></i>Enclos Publics
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['joueur_id'])): ?>
                        <?php $currentPlayer = $currentPlayer ?? null; ?>
                        <?php if ($currentPlayer): ?>
                        <div class="hidden md:flex items-center space-x-4 text-sm">
                            <span class="text-cyber-blue">
                                <i class="fas fa-user mr-1"></i><?= htmlspecialchars($currentPlayer['pseudo']) ?>
                            </span>
                            <span class="text-yellow-400">
                                <i class="fas fa-coins mr-1"></i><?= number_format($currentPlayer['ors']) ?>
                            </span>
                            <span class="text-cyber-purple">
                                <i class="fas fa-star mr-1"></i><?= htmlspecialchars($currentPlayer['rang']) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>auth/logout" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i>Déconnexion
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>auth/login" class="bg-cyber-blue hover:bg-cyber-purple px-4 py-2 rounded-lg transition-colors text-dark-bg font-semibold">
                            <i class="fas fa-sign-in-alt mr-1"></i>Connexion
                        </a>
                        <a href="<?= BASE_URL ?>auth/register" class="border border-cyber-blue hover:bg-cyber-blue hover:text-dark-bg px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-user-plus mr-1"></i>Inscription
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?php if (isset($content)) echo $content; ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-dark-card/50 border-t border-cyber-blue/30 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-400">
                <p>&copy; 2025 Monster Hunter RPG. Tous droits réservés.</p>
                <p class="mt-2 text-sm">Chassez, capturez, collectionnez !</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Particle background animation
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');
        
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        
        const particles = [];
        const particleCount = 50;
        
        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.size = Math.random() * 2 + 1;
                this.opacity = Math.random() * 0.5 + 0.2;
            }
            
            update() {
                this.x += this.vx;
                this.y += this.vy;
                
                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
            }
            
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(0, 245, 255, ${this.opacity})`;
                ctx.fill();
            }
        }
        
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }
        
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });
            
            requestAnimationFrame(animate);
        }
        
        animate();
        
        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    </script>
</body>
</html>