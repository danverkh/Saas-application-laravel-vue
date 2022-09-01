import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler.js'

const app = createApp({})

import MobileNavButton from './components/MobileNavButton.vue'
import VideoPlayer from './components/VideoPlayer.vue'

app.component('mobile-nav-button', MobileNavButton)
app.component('video-player', VideoPlayer)

// homepage
import MainSearch from './pages/homepage/MainSearch.vue'

app.component('main-search', MainSearch)

// booking page
import RankingsTable from './pages/booking/RankingsTable.vue'
import QuerySwitcher from './pages/booking/QuerySwitcher.vue'
import ForecastedResults from './pages/booking/ForecastedResults.vue'

app.component('rankings-table', RankingsTable)
app.component('query-switcher', QuerySwitcher)
app.component('forecasted-results', ForecastedResults)

app.mount('#app')
