import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler.js'
import VideoPlayer from './components/VideoPlayer.vue'
import MarketSelect from './pages/homepage/MarketSelect.vue'
import MobileNavButton from './components/MobileNavButton.vue'

const app = createApp({})

app.component('video-player', VideoPlayer)
app.component('market-select', MarketSelect)
app.component('mobile-nav-button', MobileNavButton)

app.mount('#app')
