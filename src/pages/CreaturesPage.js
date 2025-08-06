import { Layout } from '../components/Layout.js'
import { gameState } from '../js/gameState.js'
import { Utils } from '../js/utils.js'

export class CreaturesPage {
  constructor() {
    this.selectedRarity = 'all'
    this.searchTerm = ''
  }

  render() {
    Layout.render()
    const container = Layout.getPageContainer()
    
    container.innerHTML = `
      <div class="fade-in">
        <h1 class="page-title">Bestiaire</h1>
        
        <div class="card mb-6">
          <div class="card-header">
            <h2 class="card-title">Filtres</h2>
          </div>
          <div class="card-content">
            <div class="grid grid-2 gap-4">
              <div class="form-group">
                <label class="form-label">Rechercher une créature</label>
                <input 
                  type="text" 
                  id="search-input" 
                  class="form-input" 
                  placeholder="Nom de la créature..."
                  value="${this.searchTerm}"
                >
              </div>
              <div class="form-group">
                <label class="form-label">Filtrer par rareté</label>
                <select id="rarity-filter" class="form-input">
                  <option value="all" ${this.selectedRarity === 'all' ? 'selected' : ''}>Toutes les raretés</option>
                  <option value="commun" ${this.selectedRarity === 'commun' ? 'selected' : ''}>Commun</option>
                  <option value="peu_commun" ${this.selectedRarity === 'peu_commun' ? 'selected' : ''}>Peu commun</option>
                  <option value="rare" ${this.selectedRarity === 'rare' ? 'selected' : ''}>Rare</option>
                  <option value="epique" ${this.selectedRarity === 'epique' ? 'selected' : ''}>Épique</option>
                  <option value="legendaire" ${this.selectedRarity === 'legendaire' ? 'selected' : ''}>Légendaire</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-2 mb-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">📊 Statistiques du Bestiaire</h3>
            </div>
            <div class="card-content">
              <div class="stats-grid">
                <div class="stat-item">
                  <div class="stat-value">${gameState.creatures.length}</div>
                  <div class="stat-label">Total</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${this.getCreaturesByRarity('commun').length}</div>
                  <div class="stat-label">Commun</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${this.getCreaturesByRarity('peu_commun').length}</div>
                  <div class="stat-label">Peu commun</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${this.getCreaturesByRarity('rare').length}</div>
                  <div class="stat-label">Rare</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${this.getCreaturesByRarity('epique').length}</div>
                  <div class="stat-label">Épique</div>
                </div>
                <div class="stat-item">
                  <div class="stat-value">${this.getCreaturesByRarity('legendaire').length}</div>
                  <div class="stat-label">Légendaire</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">🎯 Probabilités de Rencontre</h3>
            </div>
            <div class="card-content">
              <div class="space-y-3">
                <div class="flex justify-between items-center">
                  <span class="badge badge-common">Commun</span>
                  <span>50%</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="badge badge-uncommon">Peu commun</span>
                  <span>30%</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="badge badge-rare">Rare</span>
                  <span>15%</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="badge badge-epic">Épique</span>
                  <span>4%</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="badge badge-legendary">Légendaire</span>
                  <span>1%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div id="creatures-grid" class="grid grid-3">
          ${this.renderCreatures()}
        </div>
      </div>
    `

    this.setupEventListeners()
  }

  renderCreatures() {
    const filteredCreatures = this.getFilteredCreatures()
    
    if (filteredCreatures.length === 0) {
      return `
        <div class="col-span-full text-center p-8">
          <p class="text-xl text-secondary">Aucune créature trouvée avec ces critères.</p>
        </div>
      `
    }

    return filteredCreatures.map(creature => `
      <div class="card creature-card" onclick="this.showCreatureDetails(${creature.id})">
        <div class="creature-image">
          ${Utils.getCreatureEmoji(creature.nom)}
        </div>
        <div class="creature-info">
          <div class="creature-name">${creature.nom}</div>
          <span class="badge ${Utils.getRarityBadgeClass(creature.rarete)}">${creature.rarete}</span>
        </div>
        <p class="text-sm text-secondary mb-4">${creature.description}</p>
        <div class="flex justify-between items-center text-sm">
          <span class="text-muted">Niveau max: ${creature.niveau_max}</span>
          <button class="btn btn-sm btn-outline" onclick="event.stopPropagation(); this.showCreatureDetails(${creature.id})">
            Détails
          </button>
        </div>
      </div>
    `).join('')
  }

  getFilteredCreatures() {
    let filtered = gameState.creatures

    // Filter by rarity
    if (this.selectedRarity !== 'all') {
      filtered = filtered.filter(creature => creature.rarete === this.selectedRarity)
    }

    // Filter by search term
    if (this.searchTerm) {
      filtered = filtered.filter(creature => 
        creature.nom.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
        creature.description.toLowerCase().includes(this.searchTerm.toLowerCase())
      )
    }

    return filtered
  }

  getCreaturesByRarity(rarity) {
    return gameState.creatures.filter(creature => creature.rarete === rarity)
  }

  setupEventListeners() {
    const searchInput = document.getElementById('search-input')
    const rarityFilter = document.getElementById('rarity-filter')

    if (searchInput) {
      searchInput.addEventListener('input', Utils.debounce((e) => {
        this.searchTerm = e.target.value
        this.updateCreaturesGrid()
      }, 300))
    }

    if (rarityFilter) {
      rarityFilter.addEventListener('change', (e) => {
        this.selectedRarity = e.target.value
        this.updateCreaturesGrid()
      })
    }

    // Add creature details functionality to window for onclick handlers
    window.showCreatureDetails = (creatureId) => {
      this.showCreatureDetails(creatureId)
    }
  }

  updateCreaturesGrid() {
    const grid = document.getElementById('creatures-grid')
    if (grid) {
      grid.innerHTML = this.renderCreatures()
    }
  }

  showCreatureDetails(creatureId) {
    const creature = gameState.getCreatureById(creatureId)
    if (!creature) return

    const captureChance = gameState.isLoggedIn 
      ? Utils.calculateCaptureChance({ niveau: creature.niveau_max }, gameState.player, creature.rarete)
      : 0

    const content = `
      <div class="creature-details">
        <div class="creature-image mb-4" style="height: 150px; font-size: 4rem;">
          ${Utils.getCreatureEmoji(creature.nom)}
        </div>
        <div class="mb-4">
          <h3 class="text-xl font-bold mb-2">${creature.nom}</h3>
          <span class="badge ${Utils.getRarityBadgeClass(creature.rarete)} mb-4">${creature.rarete}</span>
        </div>
        <p class="text-secondary mb-4">${creature.description}</p>
        
        <div class="grid grid-2 gap-4 mb-4">
          <div class="stat-item">
            <div class="stat-value">${creature.niveau_max}</div>
            <div class="stat-label">Niveau Maximum</div>
          </div>
          <div class="stat-item">
            <div class="stat-value">${this.getRarityAppearanceChance(creature.rarete)}%</div>
            <div class="stat-label">Chance d'apparition</div>
          </div>
        </div>

        ${gameState.isLoggedIn ? `
          <div class="mb-4">
            <h4 class="font-bold mb-2">Chances de capture (niveau max)</h4>
            <div class="progress mb-2">
              <div class="progress-bar" style="width: ${captureChance * 100}%"></div>
            </div>
            <p class="text-sm text-muted">
              ${Math.round(captureChance * 100)}% de chance de capture au niveau ${creature.niveau_max}
            </p>
          </div>
        ` : ''}

        <div class="mb-4">
          <h4 class="font-bold mb-2">Statuts possibles</h4>
          <div class="flex gap-2 flex-wrap">
            <span class="badge badge-normal">Normal (70%)</span>
            <span class="badge badge-elite">Élite (20%)</span>
            <span class="badge badge-alpha">Alpha (9%)</span>
            <span class="badge badge-boss">Boss (1%)</span>
          </div>
        </div>

        ${this.renderCreatureResources(creature)}
      </div>
    `

    Utils.showModal(`Détails - ${creature.nom}`, content)
  }

  renderCreatureResources(creature) {
    // This would normally come from the database
    const resources = this.getCreatureResources(creature.id)
    
    if (resources.length === 0) {
      return ''
    }

    return `
      <div>
        <h4 class="font-bold mb-2">Ressources possibles</h4>
        <div class="space-y-2">
          ${resources.map(resource => `
            <div class="flex justify-between items-center p-2 bg-gray-800 rounded">
              <span>${resource.nom}</span>
              <span class="text-sm text-muted">${Math.round(resource.probabilite * 100)}%</span>
            </div>
          `).join('')}
        </div>
      </div>
    `
  }

  getCreatureResources(creatureId) {
    // Simulated resource data based on creature
    const resourceMap = {
      1: [{ nom: 'Peau de gobelin', probabilite: 0.7 }],
      2: [{ nom: 'Griffe de loup', probabilite: 0.6 }],
      3: [{ nom: 'Plume de griffon', probabilite: 0.4 }],
      4: [
        { nom: 'Écaille de dragon', probabilite: 0.6 },
        { nom: 'Œuf de dragon', probabilite: 0.01 }
      ],
      5: [{ nom: 'Cendre de phénix', probabilite: 0.3 }]
    }

    return resourceMap[creatureId] || []
  }

  getRarityAppearanceChance(rarity) {
    const chances = {
      'commun': 50,
      'peu_commun': 30,
      'rare': 15,
      'epique': 4,
      'legendaire': 1
    }
    return chances[rarity] || 0
  }

  destroy() {
    // Clean up global functions
    if (window.showCreatureDetails) {
      delete window.showCreatureDetails
    }
  }
}