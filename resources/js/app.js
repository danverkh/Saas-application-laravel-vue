import './bootstrap';

import {createApp} from 'vue/dist/vue.esm-bundler.js'
import {createPinia} from 'pinia'
import piniaPluginPersistedState from 'pinia-plugin-persistedstate'
import SlideUpDown from 'vue3-slide-up-down'
import GlobalComponents from './plugins/globalComponents'
import GlobalState from './plugins/globalState'

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
import GlobalNotifications from './components/GlobalNotifications.vue'
import LoginForm from './pages/layout/LoginForm.vue'
import CampaignProgressPredictionChart from './components/charts/CampaignProgressPredictionChart.vue'
import RankingImprovementChart from './components/charts/RankingImprovementChart.vue'

app.component('full-screen-spinner', FullScreenSpinner)
app.component('domain-switcher-modal', DomainSwitcherModal)
app.component('global-notifications', GlobalNotifications)
app.component('login-form', LoginForm)
app.component('campaign-progress-prediction-chart', CampaignProgressPredictionChart)
app.component('ranking-improvement-chart', RankingImprovementChart)

// Homepage
import MainSearch from './pages/homepage/MainSearch.vue'

app.component('main-search', MainSearch)

// How it works
import HowItWorksChart from './pages/how_it_works/Chart.vue'

app.component('how-it-works-chart', HowItWorksChart)

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

// Dashboard
import CancelKeywordConfirmation from './pages/dashboard/reports/CancelKeywordConfirmation.vue'

app.component('cancel-keyword-confirmation', CancelKeywordConfirmation)

// Book a demo
import BookADemoForm from './pages/book_a_demo/Form.vue'

app.component('book-a-demo-form', BookADemoForm)

// Globals
import Helpers from "./mixins/Helpers";

app.use(pinia)
    .use(GlobalComponents)
    .use(GlobalState)
    .mixin(Helpers)
    .component('slide-up-down', SlideUpDown)
    .mount('#app');

// hidden initially to remove flicker on page load
document.querySelector('.drawer-side').style.display = 'grid';
