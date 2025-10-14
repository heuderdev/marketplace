// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    host: true,            // escuta 0.0.0.0 para acesso externo/proxy
    port: 5173,
    strictPort: true,
    hmr: {
      host: '735765ebde1a.ngrok-free.app', // domínio completo do túnel
      protocol: 'wss',     // WebSocket seguro para página HTTPS
      clientPort: 443,     // necessário atrás do ngrok https
    },
    // opcional, ajuda a gerar URLs absolutas corretas em integrações backend
    origin: 'https://735765ebde1a.ngrok-free.app',
  },
});
