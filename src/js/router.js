import { HomePage } from '../pages/HomePage.js'
import { HuntPage } from '../pages/HuntPage.js'
import { ProfilePage } from '../pages/ProfilePage.js'
import { CreaturesPage } from '../pages/CreaturesPage.js'
import { LoginPage } from '../pages/LoginPage.js'
import { RegisterPage } from '../pages/RegisterPage.js'

export class Router {
  constructor() {
    this.routes = {
      '/': HomePage,
      '/hunt': HuntPage,
      '/profile': ProfilePage,
      '/creatures': CreaturesPage,
      '/login': LoginPage,
      '/register': RegisterPage
    }
    this.currentPage = null
  }

  init() {
    // Handle initial route
    this.handleRoute()
    
    // Listen for navigation
    window.addEventListener('popstate', () => this.handleRoute())
    
    // Handle navigation links
    document.addEventListener('click', (e) => {
      if (e.target.matches('[data-route]')) {
        e.preventDefault()
        const route = e.target.getAttribute('data-route')
        this.navigate(route)
      }
    })
  }

  navigate(path) {
    window.history.pushState({}, '', path)
    this.handleRoute()
  }

  handleRoute() {
    const path = window.location.pathname
    const PageClass = this.routes[path] || this.routes['/']
    
    // Update active nav link
    this.updateActiveNavLink(path)
    
    // Render page
    if (this.currentPage && this.currentPage.destroy) {
      this.currentPage.destroy()
    }
    
    this.currentPage = new PageClass()
    this.currentPage.render()
  }

  updateActiveNavLink(path) {
    // Remove active class from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
      link.classList.remove('active')
    })
    
    // Add active class to current nav link
    const activeLink = document.querySelector(`[data-route="${path}"]`)
    if (activeLink) {
      activeLink.classList.add('active')
    }
  }
}