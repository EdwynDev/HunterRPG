import { gameState } from '../js/gameState.js'

export class Layout {
  static render() {
    const app = document.getElementById('app')
    app.innerHTML = `
      <header class="header">
        <div class="container">
          <nav class="nav">
            <a href="/" class="logo" data-route="/">
              🏹 Hunter RPG
            </a>
            <ul class="nav-links">
              <li><a href="/" class="nav-link" data-route="/">Accueil</a></li>
              <li><a href="/hunt" class="nav-link" data-route="/hunt">Chasse</a></li>
              <li><a href="/creatures" class="nav-link" data-route="/creatures">Créatures</a></li>
              ${gameState.isLoggedIn ? `
                <li><a href="/profile" class="nav-link" data-route="/profile">Profil</a></li>
                <li><button class="btn btn-outline" onclick="this.logout()">Déconnexion</button></li>
              ` : `
                <li><a href="/login" class="nav-link" data-route="/login">Connexion</a></li>
                <li><a href="/register" class="nav-link" data-route="/register">Inscription</a></li>
              `}
            </ul>
          </nav>
        </div>
      </header>
      <main class="main">
        <div class="container">
          <div id="page-content"></div>
        </div>
      </main>
    `

    // Add logout functionality
    if (gameState.isLoggedIn) {
      const logoutBtn = app.querySelector('button[onclick="this.logout()"]')
      if (logoutBtn) {
        logoutBtn.onclick = () => {
          gameState.logout()
          window.location.href = '/'
        }
      }
    }
  }

  static getPageContainer() {
    return document.getElementById('page-content')
  }
}