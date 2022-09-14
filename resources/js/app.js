import './bootstrap';

import {createApp} from 'vue/dist/vue.esm-bundler.js'
import {createPinia} from 'pinia'
import piniaPluginPersistedState from 'pinia-plugin-persistedstate'

const app = createApp({})
const pinia = createPinia()
pinia.use(piniaPluginPersistedState)

import MobileNavButton from './components/MobileNavButton.vue'
import VideoPlayer from './components/VideoPlayer.vue'

app.component('mobile-nav-button', MobileNavButton)
app.component('video-player', VideoPlayer)

// Homepage
import MainSearch from './pages/homepage/MainSearch.vue'

app.component('main-search', MainSearch)

// Booking page
import RankingsTable from './pages/booking/RankingsTable.vue'
import DomainSwitcher from './pages/booking/DomainSwitcher.vue'
import ForecastedResults from './pages/booking/ForecastedResults.vue'
import PreviewRankModal from './pages/booking/PreviewRankModal.vue'

app.component('rankings-table', RankingsTable)
app.component('domain-switcher', DomainSwitcher)
app.component('forecasted-results', ForecastedResults)
app.component('preview-rank-modal', PreviewRankModal)

// Globals
import Helpers from "./mixins/Helpers";

app.mixin(Helpers)
    .use(pinia)
    .mount('#app');

// hidden initially to remove flicker on page load
document.querySelector('.drawer-side').style.display = 'grid';
