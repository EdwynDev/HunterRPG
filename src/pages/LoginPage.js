import { Layout } from '../components/Layout.js'
import { gameState } from '../js/gameState.js'
import { Utils } from '../js/utils.js'

export class LoginPage {
  render() {
    Layout.render()
    const container = Layout.getPageContainer()
    
    if (gameState.isLoggedIn) {
      container.innerHTML = `
        <div class="text-center">
          <h1 class="page-title">Déjà connecté</h1>
          <p class="text-xl text-secondary mb-6">Vous êtes déjà connecté en tant que ${gameState.player.pseudo}.</p>
          <a href="/profile" class="btn btn-primary" data-route="/profile">Voir le Profil</a>
        </div>
      `
      return
    }

    container.innerHTML = `
      <div class="fade-in">
        <div class="max-w-md mx-auto">
          <h1 class="page-title">Connexion</h1>
          
          <div class="card">
            <div class="card-content">
              <form id="login-form">
                <div class="form-group">
                  <label class="form-label" for="email">Email</label>
                  <input 
                    type="email" 
                    id="email" 
                    class="form-input" 
                    required
                    placeholder="votre@email.com"
                  >
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="password">Mot de passe</label>
                  <input 
                    type="password" 
                    id="password" 
                    class="form-input" 
                    required
                    placeholder="Votre mot de passe"
                  >
                </div>
                
                <div id="error-message" class="hidden mb-4 p-3 bg-red-500 bg-opacity-20 border border-red-500 rounded text-red-400 text-sm"></div>
                
                <button type="submit" class="btn btn-primary w-full mb-4" id="login-btn">
                  Se connecter
                </button>
              </form>
              
              <div class="text-center">
                <p class="text-secondary mb-4">Pas encore de compte ?</p>
                <a href="/register" class="btn btn-outline" data-route="/register">Créer un compte</a>
              </div>
            </div>
          </div>
          
          <div class="card mt-6">
            <div class="card-header">
              <h3 class="card-title">🎮 Compte de démonstration</h3>
            </div>
            <div class="card-content">
              <p class="text-secondary mb-4">Vous pouvez utiliser ces identifiants pour tester l'application :</p>
              <div class="bg-gray-800 p-3 rounded mb-4 font-mono text-sm">
                <div>Email: demo@hunterrpg.com</div>
                <div>Mot de passe: demo123</div>
              </div>
              <button class="btn btn-secondary w-full" id="demo-login-btn">
                Connexion Démo
              </button>
            </div>
          </div>
        </div>
      </div>
    `

    this.setupEventListeners()
  }

  setupEventListeners() {
    const form = document.getElementById('login-form')
    const demoBtn = document.getElementById('demo-login-btn')

    if (form) {
      form.addEventListener('submit', (e) => this.handleLogin(e))
    }

    if (demoBtn) {
      demoBtn.addEventListener('click', () => this.handleDemoLogin())
    }
  }

  async handleLogin(e) {
    e.preventDefault()
    
    const email = document.getElementById('email').value
    const password = document.getElementById('password').value
    const loginBtn = document.getElementById('login-btn')
    const errorMessage = document.getElementById('error-message')

    // Reset error message
    errorMessage.classList.add('hidden')
    
    // Show loading state
    loginBtn.disabled = true
    loginBtn.innerHTML = '<span class="loading"></span> Connexion...'

    try {
      // Simulate login (in real app, this would call the API)
      await new Promise(resolve => setTimeout(resolve, 1000))
      
      // For demo purposes, accept any email/password combination
      // In real app, this would validate against the database
      const mockPlayer = {
        id: 1,
        pseudo: email.split('@')[0],
        email: email,
        niveau: Math.floor(Math.random() * 20) + 1,
        rang_guilde_id: Math.floor(Math.random() * 5) + 1,
        exp_guilde: Math.floor(Math.random() * 1000),
        ors: Math.floor(Math.random() * 10000),
        date_inscription: new Date().toISOString()
      }

      // Simulate successful login
      localStorage.setItem('auth_token', 'demo_token_' + Date.now())
      gameState.player = mockPlayer
      gameState.isLoggedIn = true
      
      // Generate some demo captures
      gameState.captures = this.generateDemoCaptures()
      
      Utils.showNotification('Connexion réussie !', 'success')
      
      // Redirect to profile
      setTimeout(() => {
        window.location.href = '/profile'
      }, 1000)

    } catch (error) {
      console.error('Login error:', error)
      errorMessage.textContent = 'Erreur de connexion. Veuillez réessayer.'
      errorMessage.classList.remove('hidden')
    } finally {
      loginBtn.disabled = false
      loginBtn.innerHTML = 'Se connecter'
    }
  }

  async handleDemoLogin() {
    const demoBtn = document.getElementById('demo-login-btn')
    
    demoBtn.disabled = true
    demoBtn.innerHTML = '<span class="loading"></span> Connexion...'

    try {
      await new Promise(resolve => setTimeout(resolve, 1000))
      
      const mockPlayer = {
        id: 1,
        pseudo: 'DemoHunter',
        email: 'demo@hunterrpg.com',
        niveau: 15,
        rang_guilde_id: 4,
        exp_guilde: 750,
        ors: 5420,
        date_inscription: new Date(Date.now() - 30 * 24 * 60 * 60 * 1000).toISOString()
      }

      localStorage.setItem('auth_token', 'demo_token_' + Date.now())
      gameState.player = mockPlayer
      gameState.isLoggedIn = true
      
      // Generate demo data
      gameState.captures = this.generateDemoCaptures()
      gameState.resources = this.generateDemoResources()
      
      Utils.showNotification('Connexion démo réussie !', 'success')
      
      setTimeout(() => {
        window.location.href = '/profile'
      }, 1000)

    } catch (error) {
      console.error('Demo login error:', error)
    } finally {
      demoBtn.disabled = false
      demoBtn.innerHTML = 'Connexion Démo'
    }
  }

  generateDemoCaptures() {
    const captures = []
    const statuses = ['Normal', 'Élite', 'Alpha', 'Boss']
    
    for (let i = 0; i < 8; i++) {
      const creature = gameState.creatures[Math.floor(Math.random() * gameState.creatures.length)]
      const status = statuses[Math.floor(Math.random() * statuses.length)]
      const niveau = Math.floor(Math.random() * 20) + 1
      
      captures.push({
        id: i + 1,
        creature_id: creature.id,
        statut: status,
        niveau: niveau,
        nom_personnalise: Math.random() > 0.7 ? `Mon ${creature.nom}` : null,
        date_capture: new Date(Date.now() - Math.random() * 30 * 24 * 60 * 60 * 1000).toISOString()
      })
    }
    
    return captures
  }

  generateDemoResources() {
    return [
      { id: 1, nom: 'Peau de gobelin', quantite: 15, description: 'Matériau de base pour artisanat.' },
      { id: 2, nom: 'Griffe de loup', quantite: 8, description: 'Utilisée pour fabriquer des armes légères.' },
      { id: 3, nom: 'Plume de griffon', quantite: 3, description: 'Ressource rare utilisée pour des objets magiques.' },
      { id: 4, nom: 'Écaille de dragon', quantite: 2, description: 'Matériau solide pour armures puissantes.' }
    ]
  }

  destroy() {
    // Cleanup if needed
  }
}