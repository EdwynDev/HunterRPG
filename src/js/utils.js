export class Utils {
  static formatNumber(num) {
    if (num >= 1000000) {
      return (num / 1000000).toFixed(1) + 'M'
    }
    if (num >= 1000) {
      return (num / 1000).toFixed(1) + 'K'
    }
    return num.toString()
  }

  static formatDate(dateString) {
    const date = new Date(dateString)
    return date.toLocaleDateString('fr-FR', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    })
  }

  static getRarityColor(rarity) {
    const colors = {
      'commun': '#9ca3af',
      'peu_commun': '#22c55e',
      'rare': '#3b82f6',
      'epique': '#a855f7',
      'legendaire': '#f59e0b'
    }
    return colors[rarity] || colors.commun
  }

  static getStatusColor(status) {
    const colors = {
      'Normal': '#9ca3af',
      'Élite': '#22c55e',
      'Alpha': '#ef4444',
      'Boss': '#f59e0b'
    }
    return colors[status] || colors.Normal
  }

  static getRarityBadgeClass(rarity) {
    const classes = {
      'commun': 'badge-common',
      'peu_commun': 'badge-uncommon',
      'rare': 'badge-rare',
      'epique': 'badge-epic',
      'legendaire': 'badge-legendary'
    }
    return classes[rarity] || classes.commun
  }

  static getStatusBadgeClass(status) {
    const classes = {
      'Normal': 'badge-normal',
      'Élite': 'badge-elite',
      'Alpha': 'badge-alpha',
      'Boss': 'badge-boss'
    }
    return classes[status] || classes.Normal
  }

  static getCreatureEmoji(creatureName) {
    const emojis = {
      'Gobelin': '👹',
      'Loup': '🐺',
      'Griffon': '🦅',
      'Dragon': '🐉',
      'Phénix': '🔥'
    }
    return emojis[creatureName] || '👾'
  }

  static calculateCaptureChance(creature, player, rarity) {
    const baseCapture = {
      'commun': 0.8,
      'peu_commun': 0.6,
      'rare': 0.4,
      'epique': 0.2,
      'legendaire': 0.05
    }

    const base = baseCapture[rarity] || 0.8
    const levelDiff = (creature.niveau - player.niveau) * 0.02
    const chance = Math.max(0.01, base - levelDiff)
    
    return Math.min(0.95, chance)
  }

  static getRandomCreature(creatures, playerLevel) {
    const rarityChances = {
      'commun': 0.5,
      'peu_commun': 0.3,
      'rare': 0.15,
      'epique': 0.04,
      'legendaire': 0.01
    }

    const rand = Math.random()
    let cumulativeChance = 0
    let selectedRarity = 'commun'

    for (const [rarity, chance] of Object.entries(rarityChances)) {
      cumulativeChance += chance
      if (rand <= cumulativeChance) {
        selectedRarity = rarity
        break
      }
    }

    const availableCreatures = creatures.filter(c => c.rarete === selectedRarity)
    const creature = availableCreatures[Math.floor(Math.random() * availableCreatures.length)]

    if (!creature) return null

    // Generate random level
    const minLevel = Math.max(1, playerLevel - 5)
    const maxLevel = playerLevel + 5
    const niveau = Math.floor(Math.random() * (maxLevel - minLevel + 1)) + minLevel

    // Generate random status
    const statusChances = {
      'Normal': 0.7,
      'Élite': 0.2,
      'Alpha': 0.09,
      'Boss': 0.01
    }

    const statusRand = Math.random()
    let statusCumulative = 0
    let selectedStatus = 'Normal'

    for (const [status, chance] of Object.entries(statusChances)) {
      statusCumulative += chance
      if (statusRand <= statusCumulative) {
        selectedStatus = status
        break
      }
    }

    return {
      ...creature,
      niveau,
      statut: selectedStatus,
      id: `hunt_${Date.now()}_${Math.random()}`
    }
  }

  static showNotification(message, type = 'info') {
    const notification = document.createElement('div')
    notification.className = `notification notification-${type}`
    notification.textContent = message
    
    // Add notification styles if not already added
    if (!document.querySelector('#notification-styles')) {
      const styles = document.createElement('style')
      styles.id = 'notification-styles'
      styles.textContent = `
        .notification {
          position: fixed;
          top: 20px;
          right: 20px;
          padding: 1rem 1.5rem;
          border-radius: 0.5rem;
          color: white;
          font-weight: 500;
          z-index: 1001;
          animation: slideInRight 0.3s ease, fadeOut 0.3s ease 2.7s;
          animation-fill-mode: forwards;
        }
        .notification-info { background: #3b82f6; }
        .notification-success { background: #10b981; }
        .notification-warning { background: #f59e0b; }
        .notification-error { background: #ef4444; }
        @keyframes slideInRight {
          from { transform: translateX(100%); opacity: 0; }
          to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
          to { opacity: 0; transform: translateX(100%); }
        }
      `
      document.head.appendChild(styles)
    }
    
    document.body.appendChild(notification)
    
    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification)
      }
    }, 3000)
  }

  static showModal(title, content, actions = []) {
    const modal = document.createElement('div')
    modal.className = 'modal'
    modal.innerHTML = `
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">${title}</h3>
          <button class="modal-close" data-modal-close>&times;</button>
        </div>
        <div class="modal-body">
          ${content}
        </div>
        ${actions.length > 0 ? `
          <div class="modal-actions" style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
            ${actions.map(action => `
              <button class="btn ${action.class || 'btn-primary'}" onclick="${action.onclick}">
                ${action.text}
              </button>
            `).join('')}
          </div>
        ` : ''}
      </div>
    `
    
    document.body.appendChild(modal)
    
    // Show modal with animation
    setTimeout(() => modal.classList.add('active'), 10)
    
    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        this.closeModal(modal)
      }
    })
    
    return modal
  }

  static closeModal(modal) {
    modal.classList.remove('active')
    setTimeout(() => {
      if (modal.parentNode) {
        modal.parentNode.removeChild(modal)
      }
    }, 300)
  }

  static debounce(func, wait) {
    let timeout
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout)
        func(...args)
      }
      clearTimeout(timeout)
      timeout = setTimeout(later, wait)
    }
  }

  static throttle(func, limit) {
    let inThrottle
    return function() {
      const args = arguments
      const context = this
      if (!inThrottle) {
        func.apply(context, args)
        inThrottle = true
        setTimeout(() => inThrottle = false, limit)
      }
    }
  }
}