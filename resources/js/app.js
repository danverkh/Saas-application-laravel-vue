import './bootstrap';

import {createApp} from 'vue/dist/vue.esm-bundler.js'
import {createPinia} from 'pinia'
import piniaPluginPersistedState from 'pinia-plugin-persistedstate'
import SlideUpDown from 'vue3-slide-up-down'

const app = createApp({})
const pinia = createPinia()
pinia.use(piniaPluginPersistedState)

import MobileNavButton from './components/MobileNavButton.vue'
import VideoPlayer from './components/VideoPlayer.vue'

app.component('mobile-nav-button', MobileNavButton)
app.component('video-player', VideoPlayer)

// Global
import FullScreenSpinner from './components/FullScreenSpinner.vue'
import DomainSwitcherModal from './components/DomainSwitcherModal.vue'

app.component('full-screen-spinner', FullScreenSpinner)
app.component('domain-switcher-modal', DomainSwitcherModal)

// Homepage
import MainSearch from './pages/homepage/MainSearch.vue'

app.component('main-search', MainSearch)

// Booking page
import RankingsTable from './pages/booking/RankingsTable.vue'
import PreviewRankModal from './pages/booking/PreviewRankModal.vue'
import DomainSwitcher from './pages/booking/aside/DomainSwitcher.vue'
import ForecastedResults from './pages/booking/aside/ForecastedResults.vue'
import Checkout from './pages/booking/aside/Checkout.vue'

app.component('rankings-table', RankingsTable)
app.component('checkout', Checkout)
app.component('domain-switcher', DomainSwitcher)
app.component('forecasted-results', ForecastedResults)
app.component('preview-rank-modal', PreviewRankModal)

// Checkout
import SubmitOrderButton from './pages/checkout/SubmitOrderButton.vue'

app.component('submit-order-button', SubmitOrderButton)

// Book a demo
import BookADemoForm from './pages/book_a_demo/Form.vue'

app.component('book-a-demo-form', BookADemoForm)

// Globals
import Helpers from "./mixins/Helpers";

app.use(pinia)
    .mixin(Helpers)
    .component('slide-up-down', SlideUpDown)
    .mount('#app');

// hidden initially to remove flicker on page load
document.querySelector('.drawer-side').style.display = 'grid';
