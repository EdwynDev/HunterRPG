import { Layout } from '../components/Layout.js'
import { gameState } from '../js/gameState.js'
import { Utils } from '../js/utils.js'

export class RegisterPage {
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
          <h1 class="page-title">Inscription</h1>
          
          <div class="card">
            <div class="card-content">
              <form id="register-form">
                <div class="form-group">
                  <label class="form-label" for="pseudo">Pseudo</label>
                  <input 
                    type="text" 
                    id="pseudo" 
                    class="form-input" 
                    required
                    minlength="3"
                    maxlength="20"
                    placeholder="Votre nom de chasseur"
                  >
                  <div class="text-xs text-muted mt-1">3-20 caractères</div>
                </div>
                
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
                    minlength="6"
                    placeholder="Au moins 6 caractères"
                  >
                  <div class="text-xs text-muted mt-1">Minimum 6 caractères</div>
                </div>
                
                <div class="form-group">
                  <label class="form-label" for="confirm-password">Confirmer le mot de passe</label>
                  <input 
                    type="password" 
                    id="confirm-password" 
                    class="form-input" 
                    required
                    placeholder="Répétez votre mot de passe"
                  >
                </div>
                
                <div id="error-message" class="hidden mb-4 p-3 bg-red-500 bg-opacity-20 border border-red-500 rounded text-red-400 text-sm"></div>
                
                <button type="submit" class="btn btn-primary w-full mb-4" id="register-btn">
                  Créer mon compte
                </button>
              </form>
              
              <div class="text-center">
                <p class="text-secondary mb-4">Déjà un compte ?</p>
                <a href="/login" class="btn btn-outline" data-route="/login">Se connecter</a>
              </div>
            </div>
          </div>
          
          <div class="card mt-6">
            <div class="card-header">
              <h3 class="card-title">🎯 Commencez votre aventure</h3>
            </div>
            <div class="card-content">
              <ul style="list-style: none; padding: 0;">
                <li class="mb-2">🏹 Partez en chasse pour découvrir des créatures</li>
                <li class="mb-2">⚔️ Capturez ou éliminez vos adversaires</li>
                <li class="mb-2">📈 Progressez dans la guilde des aventuriers</li>
                <li class="mb-2">🏆 Collectionnez des créatures rares et légendaires</li>
                <li class="mb-2">🔧 Utilisez les ressources pour l'artisanat</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    `

    this.setupEventListeners()
  }

  setupEventListeners() {
    const form = document.getElementById('register-form')
    const passwordInput = document.getElementById('password')
    const confirmPasswordInput = document.getElementById('confirm-password')

    if (form) {
      form.addEventListener('submit', (e) => this.handleRegister(e))
    }

    // Real-time password confirmation validation
    if (confirmPasswordInput) {
      confirmPasswordInput.addEventListener('input', () => {
        this.validatePasswordConfirmation()
      })
    }

    if (passwordInput) {
      passwordInput.addEventListener('input', () => {
        this.validatePasswordConfirmation()
      })
    }
  }

  validatePasswordConfirmation() {
    const password = document.getElementById('password').value
    const confirmPassword = document.getElementById('confirm-password').value
    const confirmInput = document.getElementById('confirm-password')

    if (confirmPassword && password !== confirmPassword) {
      confirmInput.style.borderColor = '#ef4444'
    } else {
      confirmInput.style.borderColor = ''
    }
  }

  async handleRegister(e) {
    e.preventDefault()
    
    const pseudo = document.getElementById('pseudo').value.trim()
    const email = document.getElementById('email').value.trim()
    const password = document.getElementById('password').value
    const confirmPassword = document.getElementById('confirm-password').value
    const registerBtn = document.getElementById('register-btn')
    const errorMessage = document.getElementById('error-message')

    // Reset error message
    errorMessage.classList.add('hidden')

    // Validation
    if (password !== confirmPassword) {
      this.showError('Les mots de passe ne correspondent pas.')
      return
    }

    if (pseudo.length < 3 || pseudo.length > 20) {
      this.showError('Le pseudo doit contenir entre 3 et 20 caractères.')
      return
    }

    if (password.length < 6) {
      this.showError('Le mot de passe doit contenir au moins 6 caractères.')
      return
    }

    // Show loading state
    registerBtn.disabled = true
    registerBtn.innerHTML = '<span class="loading"></span> Création du compte...'

    try {
      // Simulate registration (in real app, this would call the API)
      await new Promise(resolve => setTimeout(resolve, 1500))
      
      // For demo purposes, create a new player
      const mockPlayer = {
        id: Date.now(),
        pseudo: pseudo,
        email: email,
        niveau: 1,
        rang_guilde_id: 1, // Rank F
        exp_guilde: 0,
        ors: 100, // Starting gold
        date_inscription: new Date().toISOString()
      }

      // Simulate successful registration
      localStorage.setItem('auth_token', 'demo_token_' + Date.now())
      gameState.player = mockPlayer
      gameState.isLoggedIn = true
      gameState.captures = []
      gameState.resources = []
      
      Utils.showNotification('🎉 Compte créé avec succès ! Bienvenue dans Hunter RPG !', 'success')
      
      // Show welcome modal
      this.showWelcomeModal(pseudo)
      
      // Redirect to hunt page after modal
      setTimeout(() => {
        window.location.href = '/hunt'
      }, 3000)

    } catch (error) {
      console.error('Registration error:', error)
      this.showError('Erreur lors de la création du compte. Veuillez réessayer.')
    } finally {
      registerBtn.disabled = false
      registerBtn.innerHTML = 'Créer mon compte'
    }
  }

  showError(message) {
    const errorMessage = document.getElementById('error-message')
    errorMessage.textContent = message
    errorMessage.classList.remove('hidden')
    
    // Scroll to error message
    errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' })
  }

  showWelcomeModal(pseudo) {
    const content = `
      <div class="text-center">
        <div class="text-6xl mb-4">🎉</div>
        <h3 class="text-2xl font-bold mb-4">Bienvenue, ${pseudo} !</h3>
        <p class="text-secondary mb-6">
          Votre aventure de chasseur de monstres commence maintenant ! 
          Vous débutez au rang F de la guilde des aventuriers avec 100 pièces d'or.
        </p>
        
        <div class="bg-gray-800 p-4 rounded-lg mb-6">
          <h4 class="font-bold mb-3">🎯 Premiers pas :</h4>
          <ul style="list-style: none; padding: 0; text-align: left;">
            <li class="mb-2">1. 🏹 Partez en chasse pour rencontrer votre première créature</li>
            <li class="mb-2">2. ⚔️ Choisissez de la capturer ou de l'éliminer</li>
            <li class="mb-2">3. 📈 Gagnez de l'expérience pour progresser dans la guilde</li>
            <li class="mb-2">4. 🏆 Collectionnez des créatures rares et légendaires</li>
          </ul>
        </div>
        
        <p class="text-sm text-muted mb-4">
          Cette fenêtre se fermera automatiquement et vous serez redirigé vers la zone de chasse.
        </p>
        
        <div class="flex justify-center">
          <div class="loading"></div>
        </div>
      </div>
    `

    Utils.showModal('🏹 Hunter RPG', content)
  }

  destroy() {
    // Cleanup if needed
  }
}