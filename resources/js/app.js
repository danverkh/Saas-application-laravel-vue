import './bootstrap';

import {createApp} from 'vue/dist/vue.esm-bundler.js'
import {createPinia} from 'pinia'

const app = createApp({})
const pinia = createPinia()

import MobileNavButton from './components/MobileNavButton.vue'
import VideoPlayer from './components/VideoPlayer.vue'

app.component('mobile-nav-button', MobileNavButton)
app.component('video-player', VideoPlayer)

// Homepage
import MainSearch from './pages/homepage/MainSearch.vue'

app.component('main-search', MainSearch)

// Booking page
import RankingsTable from './pages/booking/RankingsTable.vue'
import QuerySwitcher from './pages/booking/QuerySwitcher.vue'
import ForecastedResults from './pages/booking/ForecastedResults.vue'

app.component('rankings-table', RankingsTable)
app.component('query-switcher', QuerySwitcher)
app.component('forecasted-results', ForecastedResults)

// Globals
import Helpers from "./mixins/Helpers";

app.mixin(Helpers)
    .use(pinia)
    .mount('#app')
