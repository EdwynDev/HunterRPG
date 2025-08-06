export class API {
  constructor() {
    this.baseUrl = '/api'
  }

  async request(endpoint, options = {}) {
    const url = `${this.baseUrl}${endpoint}`
    const config = {
      headers: {
        'Content-Type': 'application/json',
        ...options.headers
      },
      ...options
    }

    // Add auth token if available
    const token = localStorage.getItem('auth_token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }

    try {
      const response = await fetch(url, config)
      
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }
      
      return await response.json()
    } catch (error) {
      console.error('API request failed:', error)
      throw error
    }
  }

  // Hunt endpoints
  async startHunt() {
    return this.request('/hunt/start', { method: 'POST' })
  }

  async captureCreature(huntId) {
    return this.request('/hunt/capture', {
      method: 'POST',
      body: JSON.stringify({ huntId })
    })
  }

  async killCreature(huntId) {
    return this.request('/hunt/kill', {
      method: 'POST',
      body: JSON.stringify({ huntId })
    })
  }

  // Player endpoints
  async getProfile() {
    return this.request('/player/profile')
  }

  async getCaptures() {
    return this.request('/player/captures')
  }

  async getResources() {
    return this.request('/player/resources')
  }

  // Creatures endpoints
  async getCreatures() {
    return this.request('/creatures')
  }

  async getCreature(id) {
    return this.request(`/creatures/${id}`)
  }

  // Auth endpoints
  async login(email, password) {
    return this.request('/auth/login', {
      method: 'POST',
      body: JSON.stringify({ email, password })
    })
  }

  async register(pseudo, email, password) {
    return this.request('/auth/register', {
      method: 'POST',
      body: JSON.stringify({ pseudo, email, password })
    })
  }

  async logout() {
    return this.request('/auth/logout', { method: 'POST' })
  }
}