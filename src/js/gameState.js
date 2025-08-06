export class GameState {
  constructor() {
    this.player = null
    this.creatures = []
    this.captures = []
    this.resources = []
    this.guilds = []
    this.isLoggedIn = false
  }

  async init() {
    // Load initial data
    await this.loadCreatures()
    await this.loadGuilds()
    
    // Check if user is logged in
    const token = localStorage.getItem('auth_token')
    if (token) {
      await this.loadPlayer()
    }
  }

  async loadPlayer() {
    try {
      const response = await fetch('/api/player/profile', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
      })
      
      if (response.ok) {
        this.player = await response.json()
        this.isLoggedIn = true
        await this.loadPlayerCaptures()
        await this.loadPlayerResources()
      } else {
        localStorage.removeItem('auth_token')
        this.isLoggedIn = false
      }
    } catch (error) {
      console.error('Error loading player:', error)
      this.isLoggedIn = false
    }
  }

  async loadCreatures() {
    try {
      const response = await fetch('/api/creatures')
      if (response.ok) {
        this.creatures = await response.json()
      }
    } catch (error) {
      console.error('Error loading creatures:', error)
      // Fallback data
      this.creatures = [
        { id: 1, nom: 'Gobelin', rarete: 'commun', niveau_max: 20, description: 'Petit monstre agressif vivant en groupe.' },
        { id: 2, nom: 'Loup', rarete: 'peu_commun', niveau_max: 25, description: 'Prédateur rapide et féroce.' },
        { id: 3, nom: 'Griffon', rarete: 'rare', niveau_max: 40, description: 'Créature majestueuse mi-lion mi-aigle.' },
        { id: 4, nom: 'Dragon', rarete: 'epique', niveau_max: 60, description: 'Bête légendaire crachant du feu.' },
        { id: 5, nom: 'Phénix', rarete: 'legendaire', niveau_max: 70, description: 'Oiseau mythique renaissant de ses cendres.' }
      ]
    }
  }

  async loadGuilds() {
    try {
      const response = await fetch('/api/guilds')
      if (response.ok) {
        this.guilds = await response.json()
      }
    } catch (error) {
      console.error('Error loading guilds:', error)
      // Fallback data
      this.guilds = [
        { id: 1, rang: 'F', exp_requise: 0 },
        { id: 2, rang: 'E', exp_requise: 100 },
        { id: 3, rang: 'D', exp_requise: 250 },
        { id: 4, rang: 'C', exp_requise: 500 },
        { id: 5, rang: 'B', exp_requise: 1000 },
        { id: 6, rang: 'A', exp_requise: 2000 },
        { id: 7, rang: 'S', exp_requise: 5000 },
        { id: 8, rang: 'SS', exp_requise: 10000 },
        { id: 9, rang: 'SSS', exp_requise: 20000 },
        { id: 10, rang: 'Ex', exp_requise: 50000 }
      ]
    }
  }

  async loadPlayerCaptures() {
    if (!this.isLoggedIn) return
    
    try {
      const response = await fetch('/api/player/captures', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
      })
      
      if (response.ok) {
        this.captures = await response.json()
      }
    } catch (error) {
      console.error('Error loading captures:', error)
    }
  }

  async loadPlayerResources() {
    if (!this.isLoggedIn) return
    
    try {
      const response = await fetch('/api/player/resources', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
      })
      
      if (response.ok) {
        this.resources = await response.json()
      }
    } catch (error) {
      console.error('Error loading resources:', error)
    }
  }

  async login(email, password) {
    try {
      const response = await fetch('/api/auth/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, password })
      })
      
      if (response.ok) {
        const data = await response.json()
        localStorage.setItem('auth_token', data.token)
        await this.loadPlayer()
        return { success: true }
      } else {
        const error = await response.json()
        return { success: false, message: error.message }
      }
    } catch (error) {
      console.error('Login error:', error)
      return { success: false, message: 'Erreur de connexion' }
    }
  }

  async register(pseudo, email, password) {
    try {
      const response = await fetch('/api/auth/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ pseudo, email, password })
      })
      
      if (response.ok) {
        const data = await response.json()
        localStorage.setItem('auth_token', data.token)
        await this.loadPlayer()
        return { success: true }
      } else {
        const error = await response.json()
        return { success: false, message: error.message }
      }
    } catch (error) {
      console.error('Register error:', error)
      return { success: false, message: 'Erreur d\'inscription' }
    }
  }

  logout() {
    localStorage.removeItem('auth_token')
    this.player = null
    this.captures = []
    this.resources = []
    this.isLoggedIn = false
  }

  getCreatureById(id) {
    return this.creatures.find(creature => creature.id === id)
  }

  getGuildById(id) {
    return this.guilds.find(guild => guild.id === id)
  }

  getCurrentGuild() {
    if (!this.player || !this.player.rang_guilde_id) return this.guilds[0]
    return this.getGuildById(this.player.rang_guilde_id)
  }

  getNextGuild() {
    const currentGuild = this.getCurrentGuild()
    const currentIndex = this.guilds.findIndex(guild => guild.id === currentGuild.id)
    return this.guilds[currentIndex + 1] || null
  }

  getExpProgress() {
    if (!this.player) return 0
    const currentGuild = this.getCurrentGuild()
    const nextGuild = this.getNextGuild()
    
    if (!nextGuild) return 100
    
    const currentExp = this.player.exp_guilde - currentGuild.exp_requise
    const requiredExp = nextGuild.exp_requise - currentGuild.exp_requise
    
    return Math.min(100, (currentExp / requiredExp) * 100)
  }
}

// Global game state instance
export const gameState = new GameState()