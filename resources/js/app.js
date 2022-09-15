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
import CheckoutButton from './pages/booking/CheckoutButton.vue'
import DomainSwitcher from './pages/booking/DomainSwitcher.vue'
import ForecastedResults from './pages/booking/ForecastedResults.vue'
import PreviewRankModal from './pages/booking/PreviewRankModal.vue'

app.component('rankings-table', RankingsTable)
app.component('checkout-button', CheckoutButton)
app.component('domain-switcher', DomainSwitcher)
app.component('forecasted-results', ForecastedResults)
app.component('preview-rank-modal', PreviewRankModal)

// Checkout
import KeywordsTable from './pages/checkout/KeywordsTable.vue'
import CustomerDetails from './pages/checkout/CustomerDetails.vue'
import SubmitOrder from './pages/checkout/SubmitOrder.vue'

app.component('keywords-table', KeywordsTable)
app.component('customer-details', CustomerDetails)
app.component('submit-order', SubmitOrder)

// Globals
import Helpers from "./mixins/Helpers";

app.mixin(Helpers)
    .use(pinia)
    .mount('#app');

// hidden initially to remove flicker on page load
document.querySelector('.drawer-side').style.display = 'grid';
