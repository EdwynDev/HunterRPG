import './style.css'
import { Router } from './js/router.js'
import { GameState } from './js/gameState.js'
import { API } from './js/api.js'

class App {
  constructor() {
    this.gameState = new GameState()
    this.api = new API()
    this.router = new Router()
    this.init()
  }

  async init() {
    // Initialize the application
    await this.gameState.init()
    this.setupEventListeners()
    this.router.init()
  }

  setupEventListeners() {
    // Global event listeners
    document.addEventListener('click', (e) => {
      if (e.target.matches('[data-modal-close]')) {
        this.closeModal()
      }
    })

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.closeModal()
      }
    })
  }

  closeModal() {
    const modal = document.querySelector('.modal.active')
    if (modal) {
      modal.classList.remove('active')
    }
  }
}

// Initialize the app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new App()
})