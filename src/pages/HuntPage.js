import { Layout } from '../components/Layout.js'
import { gameState } from '../js/gameState.js'
import { Utils } from '../js/utils.js'

export class HuntPage {
  constructor() {
    this.currentHunt = null
    this.isHunting = false
  }

  render() {
    Layout.render()
    const container = Layout.getPageContainer()
    
    if (!gameState.isLoggedIn) {
      container.innerHTML = `
        <div class="text-center">
          <h1 class="page-title">Chasse aux Monstres</h1>
          <p class="text-xl text-secondary mb-6">Vous devez être connecté pour partir en chasse.</p>
          <a href="/login" class="btn btn-primary" data-route="/login">Se connecter</a>
        </div>
      `
      return
    }

    container.innerHTML = `
      <div class="fade-in">
        <h1 class="page-title">Chasse aux Monstres</h1>
        
        <div class="hunt-interface">
          ${this.renderHuntStatus()}
          ${this.renderHuntArea()}
        </div>
        
        <div class="grid grid-2 mt-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">📊 Statistiques de Chasse</h3>
            </div>
            <div class="card-content">
              <div class="stats-grid">
                <div class="stat-item">
                  <div class="stat-value">${gameState.captures.length}</div>
                  <div class="stat-label">Captures</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${Utils.formatNumber(gameState.player.ors)}</div>
                  <div class="stat-label">Or</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${gameState.player.niveau}</div>
                  <div class="stat-label">Niveau</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${gameState.getCurrentGuild().rang}</div>
                  <div class="stat-label">Rang</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">🎯 Conseils de Chasse</h3>
            </div>
            <div class="card-content">
              <ul style="list-style: none; padding: 0;">
                <li class="mb-2">🔸 Les créatures plus rares sont plus difficiles à capturer</li>
                <li class="mb-2">🔸 Votre niveau influence vos chances de capture</li>
                <li class="mb-2">🔸 Les statuts Élite, Alpha et Boss donnent plus d'EXP</li>
                <li class="mb-2">🔸 Éliminer une créature rapporte de l'or et des ressources</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    `

    this.setupEventListeners()
  }

  renderHuntStatus() {
    if (this.currentHunt) {
      return `
        <div class="hunt-result">
          <h2 class="text-2xl font-bold mb-4">Créature Rencontrée !</h2>
          ${this.renderCreatureCard(this.currentHunt)}
          ${this.renderHuntActions()}
        </div>
      `
    }

    return `
      <div class="card mb-6">
        <div class="card-header">
          <h2 class="card-title">Zone de Chasse</h2>
        </div>
        <div class="card-content text-center">
          <p class="text-lg text-secondary mb-6">Prêt à partir en chasse ? Cliquez sur le bouton ci-dessous pour commencer votre aventure.</p>
          <button id="start-hunt-btn" class="btn btn-primary btn-lg" ${this.isHunting ? 'disabled' : ''}>
            ${this.isHunting ? '<span class="loading"></span> Chasse en cours...' : '🏹 Commencer la Chasse'}
          </button>
        </div>
      </div>
    `
  }

  renderHuntArea() {
    if (this.currentHunt) return ''

    return `
      <div class="grid grid-3">
        ${gameState.creatures.map(creature => `
          <div class="card creature-card">
            <div class="creature-image">
              ${Utils.getCreatureEmoji(creature.nom)}
            </div>
            <div class="creature-info">
              <div class="creature-name">${creature.nom}</div>
              <span class="badge ${Utils.getRarityBadgeClass(creature.rarete)}">${creature.rarete}</span>
            </div>
            <p class="text-sm text-secondary mb-4">${creature.description}</p>
            <div class="text-sm text-muted">
              Niveau max: ${creature.niveau_max}
            </div>
          </div>
        `).join('')}
      </div>
    `
  }

  renderCreatureCard(creature) {
    const captureChance = Utils.calculateCaptureChance(creature, gameState.player, creature.rarete)
    
    return `
      <div class="creature-card">
        <div class="creature-image">
          ${Utils.getCreatureEmoji(creature.nom)}
        </div>
        <div class="creature-info">
          <div class="creature-name">${creature.nom}</div>
          <div class="flex gap-2 mt-2">
            <span class="badge ${Utils.getRarityBadgeClass(creature.rarete)}">${creature.rarete}</span>
            <span class="badge ${Utils.getStatusBadgeClass(creature.statut)}">${creature.statut}</span>
          </div>
        </div>
        <div class="creature-level">Niveau ${creature.niveau}</div>
        <p class="text-sm text-secondary mb-4">${creature.description}</p>
        <div class="text-sm">
          <div class="mb-2">
            <strong>Chance de capture:</strong> 
            <span style="color: ${captureChance > 0.5 ? '#22c55e' : captureChance > 0.2 ? '#f59e0b' : '#ef4444'}">
              ${Math.round(captureChance * 100)}%
            </span>
          </div>
        </div>
      </div>
    `
  }

  renderHuntActions() {
    return `
      <div class="hunt-actions">
        <button id="capture-btn" class="btn btn-success">
          🎯 Tenter la Capture
        </button>
        <button id="kill-btn" class="btn btn-warning">
          ⚔️ Éliminer
        </button>
        <button id="flee-btn" class="btn btn-outline">
          🏃 Fuir
        </button>
      </div>
    `
  }

  setupEventListeners() {
    const startHuntBtn = document.getElementById('start-hunt-btn')
    if (startHuntBtn) {
      startHuntBtn.addEventListener('click', () => this.startHunt())
    }

    const captureBtn = document.getElementById('capture-btn')
    if (captureBtn) {
      captureBtn.addEventListener('click', () => this.attemptCapture())
    }

    const killBtn = document.getElementById('kill-btn')
    if (killBtn) {
      killBtn.addEventListener('click', () => this.killCreature())
    }

    const fleeBtn = document.getElementById('flee-btn')
    if (fleeBtn) {
      fleeBtn.addEventListener('click', () => this.flee())
    }
  }

  async startHunt() {
    if (this.isHunting) return

    this.isHunting = true
    this.render()

    // Simulate hunt delay
    await new Promise(resolve => setTimeout(resolve, 2000))

    // Generate random creature
    this.currentHunt = Utils.getRandomCreature(gameState.creatures, gameState.player.niveau)
    
    if (this.currentHunt) {
      this.isHunting = false
      this.render()
      Utils.showNotification(`Vous avez rencontré un ${this.currentHunt.nom} ${this.currentHunt.statut} !`, 'info')
    } else {
      this.isHunting = false
      this.render()
      Utils.showNotification('Aucune créature trouvée cette fois-ci.', 'warning')
    }
  }

  async attemptCapture() {
    if (!this.currentHunt) return

    const captureChance = Utils.calculateCaptureChance(this.currentHunt, gameState.player, this.currentHunt.rarete)
    const success = Math.random() < captureChance

    if (success) {
      // Add to captures (simulate)
      const capture = {
        id: Date.now(),
        creature: this.currentHunt,
        date_capture: new Date().toISOString(),
        nom_personnalise: null
      }
      
      gameState.captures.push(capture)
      
      // Calculate EXP gain
      const expGain = this.calculateExpGain(this.currentHunt)
      gameState.player.exp_guilde += expGain
      
      Utils.showNotification(`🎉 Capture réussie ! +${expGain} EXP de guilde`, 'success')
      
      // Check for guild rank up
      this.checkGuildRankUp()
    } else {
      Utils.showNotification('❌ Échec de la capture ! La créature s\'est échappée.', 'error')
    }

    this.endHunt()
  }

  async killCreature() {
    if (!this.currentHunt) return

    // Calculate rewards
    const goldReward = this.calculateGoldReward(this.currentHunt)
    gameState.player.ors += goldReward

    Utils.showNotification(`⚔️ Créature éliminée ! +${goldReward} or`, 'warning')
    
    this.endHunt()
  }

  flee() {
    Utils.showNotification('🏃 Vous avez fui le combat.', 'info')
    this.endHunt()
  }

  endHunt() {
    this.currentHunt = null
    this.render()
  }

  calculateExpGain(creature) {
    const baseExp = {
      'commun': 10,
      'peu_commun': 25,
      'rare': 50,
      'epique': 100,
      'legendaire': 250
    }

    const statusMultiplier = {
      'Normal': 1,
      'Élite': 1.5,
      'Alpha': 2,
      'Boss': 3
    }

    const base = baseExp[creature.rarete] || 10
    const multiplier = statusMultiplier[creature.statut] || 1
    
    return Math.floor(base * multiplier)
  }

  calculateGoldReward(creature) {
    const baseGold = {
      'commun': 50,
      'peu_commun': 100,
      'rare': 200,
      'epique': 500,
      'legendaire': 1000
    }

    const statusMultiplier = {
      'Normal': 1,
      'Élite': 1.2,
      'Alpha': 1.5,
      'Boss': 2
    }

    const base = baseGold[creature.rarete] || 50
    const multiplier = statusMultiplier[creature.statut] || 1
    
    return Math.floor(base * multiplier * (0.8 + Math.random() * 0.4))
  }

  checkGuildRankUp() {
    const nextGuild = gameState.getNextGuild()
    if (nextGuild && gameState.player.exp_guilde >= nextGuild.exp_requise) {
      gameState.player.rang_guilde_id = nextGuild.id
      Utils.showNotification(`🏆 Félicitations ! Vous avez atteint le rang ${nextGuild.rang} !`, 'success')
    }
  }

  destroy() {
    // Cleanup if needed
  }
}