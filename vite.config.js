import { defineConfig } from 'vite'

export default defineConfig({
  server: {
    proxy: {
      '/api': {
        target: 'http://localhost:8080',
        changeOrigin: true,
        configure: (proxy, options) => {
          // Fallback to mock API if PHP server is not running
          proxy.on('error', (err, req, res) => {
            console.log('API proxy error, using mock data')
            res.writeHead(200, { 'Content-Type': 'application/json' })
            res.end(JSON.stringify({ error: 'API not available, using mock data' }))
          })
        }
      }
    }
  }
})