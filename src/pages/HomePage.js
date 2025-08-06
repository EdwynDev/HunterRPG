import { Layout } from '../components/Layout.js'
import { gameState } from '../js/gameState.js'
import { Utils } from '../js/utils.js'

export class HomePage {
  render() {
    Layout.render()
    const container = Layout.getPageContainer()
    
    container.innerHTML = `
      <div class="fade-in">
        <h1 class="page-title">Bienvenue dans Hunter RPG</h1>
        
        ${gameState.isLoggedIn ? this.renderDashboard() : this.renderWelcome()}
        
        <div class="grid grid-3 mt-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">🏹 Système de Chasse</h3>
            </div>
            <div class="card-content">
              <p>Partez à la chasse pour découvrir des créatures mystérieuses. Chaque chasse est unique avec des rencontres aléatoires et des défis variés.</p>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">⚔️ Combat & Capture</h3>
            </div>
            <div class="card-content">
              <p>Affrontez des créatures de différentes raretés et statuts. Capturez-les pour enrichir votre collection ou éliminez-les pour des ressources.</p>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">🏆 Progression</h3>
            </div>
            <div class="card-content">
              <p>Progressez dans la guilde des aventuriers, du rang F au rang Ex. Débloquez de nouvelles capacités et zones de chasse.</p>
            </div>
          </div>
        </div>
        
        <div class="grid grid-2 mt-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">📊 Statistiques Globales</h3>
            </div>
            <div class="card-content">
              <div class="stats-grid">
                <div class="stat-item">
                  <div class="stat-value">${gameState.creatures.length}</div>
                  <div class="stat-label">Créatures</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${gameState.guilds.length}</div>
                  <div class="stat-label">Rangs</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">5</div>
                  <div class="stat-label">Raretés</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">4</div>
                  <div class="stat-label">Statuts</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">🎯 Commencer l'Aventure</h3>
            </div>
            <div class="card-content">
              ${gameState.isLoggedIn ? `
                <p class="mb-4">Vous êtes prêt à partir en chasse ! Explorez le monde et découvrez des créatures extraordinaires.</p>
                <a href="/hunt" class="btn btn-primary" data-route="/hunt">Commencer la Chasse</a>
              ` : `
                <p class="mb-4">Créez votre compte pour commencer votre aventure de chasseur de monstres.</p>
                <div class="flex gap-4">
                  <a href="/register" class="btn btn-primary" data-route="/register">S'inscrire</a>
                  <a href="/login" class="btn btn-outline" data-route="/login">Se connecter</a>
                </div>
              `}
            </div>
          </div>
        </div>
      </div>
    `
  }

  renderWelcome() {
    return `
      <div class="text-center mb-6">
        <p class="text-xl text-secondary mb-4">
          Plongez dans un monde fantastique où vous incarnez un chasseur de monstres. 
          Explorez, combattez, capturez et progressez dans la guilde des aventuriers.
        </p>
        <div class="flex justify-center gap-4">
          <a href="/register" class="btn btn-primary" data-route="/register">Commencer l'Aventure</a>
          <a href="/creatures" class="btn btn-secondary" data-route="/creatures">Découvrir les Créatures</a>
        </div>
      </div>
    `
  }

  renderDashboard() {
    const currentGuild = gameState.getCurrentGuild()
    const nextGuild = gameState.getNextGuild()
    const expProgress = gameState.getExpProgress()

    return `
      <div class="card mb-6">
        <div class="card-header">
          <h2 class="card-title">Tableau de Bord - ${gameState.player.pseudo}</h2>
        </div>
        <div class="card-content">
          <div class="grid grid-2 gap-6">
            <div>
              <h3 class="text-lg font-bold mb-4">Informations du Joueur</h3>
              <div class="stats-grid">
                <div class="stat-item">
                  <div class="stat-value">${gameState.player.niveau}</div>
                  <div class="stat-label">Niveau</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${currentGuild.rang}</div>
                  <div class="stat-label">Rang</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${Utils.formatNumber(gameState.player.ors)}</div>
                  <div class="stat-label">Or</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${gameState.captures.length}</div>
                  <div class="stat-label">Captures</div>
                </div>
              </div>
            </div>
            <div>
              <h3 class="text-lg font-bold mb-4">Progression de Guilde</h3>
              <div class="mb-4">
                <div class="flex justify-between mb-2">
                  <span>Rang ${currentGuild.rang}</span>
                  <span>${nextGuild ? `Vers ${nextGuild.rang}` : 'Rang Maximum'}</span>
                </div>
                <div class="progress">
                  <div class="progress-bar" style="width: ${expProgress}%"></div>
                </div>
                <div class="text-sm text-muted mt-2">
                  ${gameState.player.exp_guilde} / ${nextGuild ? nextGuild.exp_requise : gameState.player.exp_guilde} EXP
                </div>
              </div>
              ${nextGuild ? `
                <p class="text-sm text-secondary">
                  ${nextGuild.exp_requise - gameState.player.exp_guilde} EXP restants pour le rang ${nextGuild.rang}
                </p>
              ` : `
                <p class="text-sm text-accent">🏆 Rang maximum atteint !</p>
              `}
            </div>
          </div>
        </div>
      </div>
    `
  }

  destroy() {
    // Cleanup if needed
  }
}