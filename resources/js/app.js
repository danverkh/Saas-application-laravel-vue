import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler.js'
import VideoPlayer from './components/VideoPlayer.vue'
import MarketSelect from './components/MarketSelect.vue'

const app = createApp({})

app.component('video-player', VideoPlayer)
app.component('market-select', MarketSelect)

app.mount('#app')
