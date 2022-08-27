import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler.js'
import VideoPlayer from './components/VideoPlayer.vue'

const app = createApp({})

app.component('video-player', VideoPlayer)

app.mount('#app')
