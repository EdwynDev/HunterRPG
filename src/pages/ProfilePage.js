import { Layout } from '../components/Layout.js'
import { gameState } from '../js/gameState.js'
import { Utils } from '../js/utils.js'

export class ProfilePage {
  constructor() {
    this.activeTab = 'overview'
  }

  render() {
    Layout.render()
    const container = Layout.getPageContainer()
    
    if (!gameState.isLoggedIn) {
      container.innerHTML = `
        <div class="text-center">
          <h1 class="page-title">Profil</h1>
          <p class="text-xl text-secondary mb-6">Vous devez être connecté pour voir votre profil.</p>
          <a href="/login" class="btn btn-primary" data-route="/login">Se connecter</a>
        </div>
      `
      return
    }

    container.innerHTML = `
      <div class="fade-in">
        <h1 class="page-title">Profil de ${gameState.player.pseudo}</h1>
        
        <div class="card mb-6">
          <div class="card-content">
            <div class="flex justify-center mb-6">
              <div class="text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-primary-color to-secondary-color rounded-full flex items-center justify-center text-4xl mb-4 mx-auto">
                  🏹
                </div>
                <h2 class="text-2xl font-bold">${gameState.player.pseudo}</h2>
                <p class="text-secondary">${gameState.player.email}</p>
                <p class="text-sm text-muted">Membre depuis ${Utils.formatDate(gameState.player.date_inscription)}</p>
              </div>
            </div>
            
            <div class="grid grid-3 gap-4">
              <div class="stat-item">
                <div class="stat-value">${gameState.player.niveau}</div>
                <div class="stat-label">Niveau</div>
              </div>
              <div class="stat-item">
                <div class="stat-value">${gameState.getCurrentGuild().rang}</div>
                <div class="stat-label">Rang de Guilde</div>
              </div>
              <div class="stat-item">
                <div class="stat-value">${Utils.formatNumber(gameState.player.ors)}</div>
                <div class="stat-label">Or</div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-6">
          <div class="card-header">
            <h3 class="card-title">Progression de Guilde</h3>
          </div>
          <div class="card-content">
            ${this.renderGuildProgression()}
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="flex gap-4">
              <button class="btn ${this.activeTab === 'overview' ? 'btn-primary' : 'btn-outline'}" onclick="this.switchTab('overview')">
                Vue d'ensemble
              </button>
              <button class="btn ${this.activeTab === 'captures' ? 'btn-primary' : 'btn-outline'}" onclick="this.switchTab('captures')">
                Captures (${gameState.captures.length})
              </button>
              <button class="btn ${this.activeTab === 'resources' ? 'btn-primary' : 'btn-outline'}" onclick="this.switchTab('resources')">
                Ressources
              </button>
            </div>
          </div>
          <div class="card-content">
            <div id="tab-content">
              ${this.renderTabContent()}
            </div>
          </div>
        </div>
      </div>
    `

    this.setupEventListeners()
  }

  renderGuildProgression() {
    const currentGuild = gameState.getCurrentGuild()
    const nextGuild = gameState.getNextGuild()
    const expProgress = gameState.getExpProgress()

    return `
      <div class="mb-4">
        <div class="flex justify-between items-center mb-2">
          <span class="font-bold">Rang ${currentGuild.rang}</span>
          ${nextGuild ? `<span>Vers ${nextGuild.rang}</span>` : '<span>Rang Maximum</span>'}
        </div>
        <div class="progress mb-2">
          <div class="progress-bar" style="width: ${expProgress}%"></div>
        </div>
        <div class="flex justify-between text-sm text-muted">
          <span>${gameState.player.exp_guilde} EXP</span>
          <span>${nextGuild ? nextGuild.exp_requise : gameState.player.exp_guilde} EXP</span>
        </div>
      </div>
      
      ${nextGuild ? `
        <p class="text-sm text-secondary">
          ${nextGuild.exp_requise - gameState.player.exp_guilde} EXP restants pour atteindre le rang ${nextGuild.rang}
        </p>
      ` : `
        <p class="text-sm text-accent">🏆 Félicitations ! Vous avez atteint le rang maximum !</p>
      `}
      
      <div class="mt-6">
        <h4 class="font-bold mb-3">Tous les rangs</h4>
        <div class="grid grid-5 gap-2">
          ${gameState.guilds.map(guild => `
            <div class="text-center p-2 rounded ${guild.id === currentGuild.id ? 'bg-primary-color text-white' : gameState.player.exp_guilde >= guild.exp_requise ? 'bg-success-color text-white' : 'bg-gray-700 text-gray-400'}">
              <div class="font-bold">${guild.rang}</div>
              <div class="text-xs">${guild.exp_requise} EXP</div>
            </div>
          `).join('')}
        </div>
      </div>
    `
  }

  renderTabContent() {
    switch (this.activeTab) {
      case 'overview':
        return this.renderOverview()
      case 'captures':
        return this.renderCaptures()
      case 'resources':
        return this.renderResources()
      default:
        return this.renderOverview()
    }
  }

  renderOverview() {
    const capturesByRarity = this.getCapturesByRarity()
    const capturesByStatus = this.getCapturesByStatus()

    return `
      <div class="grid grid-2 gap-6">
        <div>
          <h4 class="font-bold mb-4">Statistiques Générales</h4>
          <div class="stats-grid">
            <div class="stat-item">
              <div class="stat-value">${gameState.captures.length}</div>
              <div class="stat-label">Total Captures</div>
            </div>
            <div class="stat-item">
              <div class="stat-value">${new Set(gameState.captures.map(c => c.creature?.id)).size}</div>
              <div class="stat-label">Espèces Uniques</div>
            </div>
            <div class="stat-item">
              <div class="stat-value">${Utils.formatNumber(gameState.player.ors)}</div>
              <div class="stat-label">Or Total</div>
            </div>
            <div class="stat-item">
              <div class="stat-value">${gameState.player.exp_guilde}</div>
              <div class="stat-label">EXP Guilde</div>
            </div>
          </div>
        </div>
        
        <div>
          <h4 class="font-bold mb-4">Répartition par Rareté</h4>
          <div class="space-y-2">
            ${Object.entries(capturesByRarity).map(([rarity, count]) => `
              <div class="flex justify-between items-center">
                <span class="badge ${Utils.getRarityBadgeClass(rarity)}">${rarity}</span>
                <span>${count}</span>
              </div>
            `).join('')}
          </div>
          
          <h4 class="font-bold mb-4 mt-6">Répartition par Statut</h4>
          <div class="space-y-2">
            ${Object.entries(capturesByStatus).map(([status, count]) => `
              <div class="flex justify-between items-center">
                <span class="badge ${Utils.getStatusBadgeClass(status)}">${status}</span>
                <span>${count}</span>
              </div>
            `).join('')}
          </div>
        </div>
      </div>
    `
  }

  renderCaptures() {
    if (gameState.captures.length === 0) {
      return `
        <div class="text-center p-8">
          <p class="text-xl text-secondary mb-4">Vous n'avez encore capturé aucune créature.</p>
          <a href="/hunt" class="btn btn-primary" data-route="/hunt">Commencer la Chasse</a>
        </div>
      `
    }

    return `
      <div class="grid grid-3 gap-4">
        ${gameState.captures.map(capture => this.renderCaptureCard(capture)).join('')}
      </div>
    `
  }

  renderCaptureCard(capture) {
    // Simulate creature data (in real app, this would be joined from database)
    const creature = gameState.getCreatureById(capture.creature_id) || {
      nom: 'Créature Inconnue',
      rarete: 'commun',
      description: 'Description non disponible'
    }

    return `
      <div class="card creature-card">
        <div class="creature-image">
          ${Utils.getCreatureEmoji(creature.nom)}
        </div>
        <div class="creature-info">
          <div class="creature-name">
            ${capture.nom_personnalise || creature.nom}
            ${capture.nom_personnalise ? `<div class="text-sm text-muted">(${creature.nom})</div>` : ''}
          </div>
          <div class="flex gap-2 mt-2">
            <span class="badge ${Utils.getRarityBadgeClass(creature.rarete)}">${creature.rarete}</span>
            <span class="badge ${Utils.getStatusBadgeClass(capture.statut || 'Normal')}">${capture.statut || 'Normal'}</span>
          </div>
        </div>
        <div class="text-sm text-muted mb-2">
          Niveau ${capture.niveau || 1}
        </div>
        <div class="text-xs text-muted">
          Capturé le ${Utils.formatDate(capture.date_capture)}
        </div>
        <div class="mt-4">
          <button class="btn btn-sm btn-outline w-full" onclick="this.showCaptureDetails(${capture.id})">
            Détails
          </button>
        </div>
      </div>
    `
  }

  renderResources() {
    if (gameState.resources.length === 0) {
      return `
        <div class="text-center p-8">
          <p class="text-xl text-secondary mb-4">Vous n'avez encore aucune ressource.</p>
          <p class="text-secondary">Éliminez des créatures lors de vos chasses pour obtenir des ressources.</p>
        </div>
      `
    }

    return `
      <div class="grid grid-2 gap-4">
        ${gameState.resources.map(resource => `
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">${resource.nom}</h4>
              <span class="badge badge-primary">${resource.quantite}</span>
            </div>
            <div class="card-content">
              <p class="text-sm text-secondary">${resource.description || 'Description non disponible'}</p>
            </div>
          </div>
        `).join('')}
      </div>
    `
  }

  getCapturesByRarity() {
    const counts = {}
    gameState.captures.forEach(capture => {
      const creature = gameState.getCreatureById(capture.creature_id)
      if (creature) {
        counts[creature.rarete] = (counts[creature.rarete] || 0) + 1
      }
    })
    return counts
  }

  getCapturesByStatus() {
    const counts = {}
    gameState.captures.forEach(capture => {
      const status = capture.statut || 'Normal'
      counts[status] = (counts[status] || 0) + 1
    })
    return counts
  }

  setupEventListeners() {
    // Add tab switching functionality to window
    window.switchTab = (tab) => {
      this.switchTab(tab)
    }

    window.showCaptureDetails = (captureId) => {
      this.showCaptureDetails(captureId)
    }
  }

  switchTab(tab) {
    this.activeTab = tab
    
    // Update tab buttons
    document.querySelectorAll('.card-header button').forEach(btn => {
      btn.className = btn.className.replace('btn-primary', 'btn-outline')
    })
    
    const activeBtn = document.querySelector(`button[onclick="this.switchTab('${tab}')"]`)
    if (activeBtn) {
      activeBtn.className = activeBtn.className.replace('btn-outline', 'btn-primary')
    }
    
    // Update content
    const tabContent = document.getElementById('tab-content')
    if (tabContent) {
      tabContent.innerHTML = this.renderTabContent()
    }
  }

  showCaptureDetails(captureId) {
    const capture = gameState.captures.find(c => c.id === captureId)
    if (!capture) return

    const creature = gameState.getCreatureById(capture.creature_id)
    if (!creature) return

    const content = `
      <div class="text-center mb-4">
        <div class="creature-image mb-4" style="height: 120px; font-size: 3rem;">
          ${Utils.getCreatureEmoji(creature.nom)}
        </div>
        <h3 class="text-xl font-bold mb-2">
          ${capture.nom_personnalise || creature.nom}
        </h3>
        ${capture.nom_personnalise ? `<p class="text-muted mb-2">Espèce: ${creature.nom}</p>` : ''}
        <div class="flex justify-center gap-2 mb-4">
          <span class="badge ${Utils.getRarityBadgeClass(creature.rarete)}">${creature.rarete}</span>
          <span class="badge ${Utils.getStatusBadgeClass(capture.statut || 'Normal')}">${capture.statut || 'Normal'}</span>
        </div>
      </div>
      
      <div class="grid grid-2 gap-4 mb-4">
        <div class="stat-item">
          <div class="stat-value">${capture.niveau || 1}</div>
          <div class="stat-label">Niveau</div>
        </div>
        <div class="stat-item">
          <div class="stat-value">${creature.niveau_max}</div>
          <div class="stat-label">Niveau Max</div>
        </div>
      </div>
      
      <div class="mb-4">
        <h4 class="font-bold mb-2">Description</h4>
        <p class="text-secondary">${creature.description}</p>
      </div>
      
      <div class="mb-4">
        <h4 class="font-bold mb-2">Informations de Capture</h4>
        <p class="text-sm text-muted">Capturé le ${Utils.formatDate(capture.date_capture)}</p>
      </div>
      
      <div class="flex gap-2 justify-center">
        <button class="btn btn-outline" onclick="this.renameCapturePrompt(${capture.id})">
          ✏️ Renommer
        </button>
        <button class="btn btn-warning" onclick="this.releaseCapturePrompt(${capture.id})">
          🕊️ Relâcher
        </button>
      </div>
    `

    Utils.showModal(`Détails - ${capture.nom_personnalise || creature.nom}`, content)
  }

  destroy() {
    // Clean up global functions
    if (window.switchTab) delete window.switchTab
    if (window.showCaptureDetails) delete window.showCaptureDetails
  }
}