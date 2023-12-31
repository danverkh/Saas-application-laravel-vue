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
import AssistantModal from './components/AssistantModal.vue'
import LoginForm from './pages/layout/LoginForm.vue'
import LoginModal from './components/LoginModal.vue'
import MobileBottomNavigation from './components/MobileBottomNavigation.vue'

app.component('full-screen-spinner', FullScreenSpinner)
app.component('domain-switcher-modal', DomainSwitcherModal)
app.component('global-notifications', GlobalNotifications)
app.component('assistant-modal', AssistantModal)
app.component('login-form', LoginForm)
app.component('login-modal', LoginModal)
app.component('mobile-bottom-navigation', MobileBottomNavigation)

// Homepage
import MainSearch from './pages/homepage/MainSearch.vue'

app.component('main-search', MainSearch)

// How it works
import HowItWorksChart from './pages/how_it_works/Chart.vue'

app.component('how-it-works-chart', HowItWorksChart)

// Success stories
import SuccessStory from './pages/success_stories/SuccessStory.vue'
import ShowMoreButton from './pages/success_stories/ShowMoreButton.vue'

app.component('success-story', SuccessStory)
app.component('show-more-success-stories-btn', ShowMoreButton)

// Pricing
import PricingVisitorsAndLeadsCalculator from './pages/pricing/PricingVisitorsAndLeadsCalculator.vue'
import PricingClientsAndValueCalculator from './pages/pricing/PricingClientsAndValueCalculator.vue'

app.component('pricing-visitors-and-leads-calculator', PricingVisitorsAndLeadsCalculator)
app.component('pricing-clients-and-value-calculator', PricingClientsAndValueCalculator)

// Booking page
import RankingsTable from './pages/booking/RankingsTable.vue'
import PreviewRankModal from './pages/booking/PreviewRankModal.vue'
import AddKeywordsModal from './pages/booking/AddKeywordsModal.vue'
import DomainSwitcher from './pages/booking/aside/DomainSwitcher.vue'
import ForecastedResults from './pages/booking/aside/ForecastedResults.vue'
import CampaignProgressPredictionChart from './components/charts/CampaignProgressPredictionChart.vue'
import Checkout from './pages/booking/aside/Checkout.vue'

app.component('rankings-table', RankingsTable)
app.component('checkout', Checkout)
app.component('domain-switcher', DomainSwitcher)
app.component('forecasted-results', ForecastedResults)
app.component('preview-rank-modal', PreviewRankModal)
app.component('add-keywords-modal', AddKeywordsModal)
app.component('campaign-progress-prediction-chart', CampaignProgressPredictionChart)

// Checkout
import SubmitOrderButton from './pages/checkout/SubmitOrderButton.vue'

app.component('submit-order-button', SubmitOrderButton)

// Dashboard
import CancelKeywordConfirmation from './pages/dashboard/campaigns/CancelKeywordConfirmation.vue'
import ReactivateKeywordConfirmation from './pages/dashboard/campaigns/ReactivateKeywordConfirmation.vue'
import BillingAddress from './pages/dashboard/account/BillingAddress.vue'
import ChangePassword from './pages/dashboard/account/ChangePassword.vue'
import CampaignsSidebar from './pages/dashboard/campaigns/CampaignsSidebar.vue'
import CampaignKeyword from './pages/dashboard/campaigns/CampaignKeyword.vue'

app.component('cancel-keyword-confirmation', CancelKeywordConfirmation)
app.component('reactivate-keyword-confirmation', ReactivateKeywordConfirmation)
app.component('billing-address', BillingAddress)
app.component('change-password', ChangePassword)
app.component('campaigns-sidebar', CampaignsSidebar)
app.component('campaign-keyword', CampaignKeyword)

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
