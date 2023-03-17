<template>
    <Modal name="assistant-modal" width="max-w-xl" overflow="overflow-visible">
        <div v-if="step === 1" class="w-full mb-8">
            <div class="text-3xl text-center py-4">What are your online<br class="hidden sm:inline"> marketing goals?</div>

            <div class="flex flex-col gap-y-3 mt-6">
                <div class="btn btn-block" @click="answers.marketing = 'conversions'" :class="answers.marketing === 'conversions' ? 'btn-primary' : 'text-zinc-800 bg-zinc-100 border-zinc-200 hover:text-white'">
                    Conversions
                </div>
                <div class="btn btn-block" @click="answers.marketing = 'branding'" :class="answers.marketing === 'branding' ? 'btn-primary' : 'text-zinc-800 bg-zinc-100 border-zinc-200 hover:text-white'">
                    Branding
                </div>
                <div class="btn btn-block" @click="answers.marketing = 'find_employees'" :class="answers.marketing === 'find_employees' ? 'btn-primary' : 'text-zinc-800 bg-zinc-100 border-zinc-200 hover:text-white'">
                    Find employees
                </div>
            </div>
        </div>

        <div v-if="step === 2" class="w-full mb-8">
            <div class="text-3xl text-center py-4">What is your domain name?</div>

            <div class="flex flex-no-wrap flex-col sm:flex-row gap-5 relative z-10 mt-3 sm:mt-6">
                <MainSearch no-search
                            :submit-on-select="false"
                            @market="answers.domainAndMarket.market = $event"
                            @domain="answers.domainAndMarket.domain = $event"></MainSearch>
            </div>
        </div>

        <div class="flex justify-between bg-zinc-100 border-t border-zinc-200 -mx-6 -mb-6 px-6 py-5 rounded-b-3xl">
            <button @click="prevStep" class="btn gap-1 px-8" :class="[step === 1 ? 'pointer-events-none opacity-10' : 'opacity-40']">
                <svg class="h-6 w-6 rotate-180 -ml-2" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M10.02 6L8.61 7.41L13.19 12l-4.58 4.59L10.02 18l6-6l-6-6z"/>
                </svg>
                Prev
            </button>

            <button v-if="step < lastStep" @click="nextStep" class="btn gap-1 px-8" :class="[canGoNext ? 'opacity-40' : 'pointer-events-none opacity-10']">
                Next
                <svg class="h-6 w-6 -mr-2" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M10.02 6L8.61 7.41L13.19 12l-4.58 4.59L10.02 18l6-6l-6-6z"/>
                </svg>
            </button>

            <button v-else @click="submit" class="btn btn-primary gap-1 px-8" :class="[canGoNext ? '' : 'pointer-events-none opacity-25', {'pointer-events-none': submitted}]">
                Submit
                <svg class="h-6 w-6 -mr-2" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M10.02 6L8.61 7.41L13.19 12l-4.58 4.59L10.02 18l6-6l-6-6z"/>
                </svg>
            </button>
        </div>
    </Modal>
</template>

<script>
import Modal from "./Modal.vue";
import MainSearch from "@/pages/homepage/MainSearch.vue";
import isNumber from 'lodash/isNumber';
import Assistant from "@/services/Assistant";
import {useCart} from "@/stores/cart";

export default {
    name: "AssistantModal",

    components: {Modal, MainSearch},

    data() {
        return {
            step: 1,
            lastStep: 2,
            answers: {
                marketing: null,
                domainAndMarket: {
                    domain: '',
                    market: null,
                },
            },
            submitted: false,
            isNumber,
        };
    },

    computed: {
        canGoNext() {
            if (this.step === 1 && this.answers.marketing !== null) {
                return true;
            }
            if (this.step === 2 && this.answers.domainAndMarket.domain) {
                return true;
            }
            return false;
        },
    },

    methods: {
        prevStep() {
            this.step--;
        },

        nextStep() {
            this.step++;
        },

        async submit() {
            const domain = encodeURIComponent(this.answers.domainAndMarket.domain);
            let market   = this.answers.domainAndMarket.market;

            if (market === null) {
                this.submitted = true;

                try {
                    const response = await axios.get(route('api.domain.market.guess'), {params: {domain}});
                    market         = response.data.market || Assistant.marketIfNotDetected;
                } catch (error) {
                    console.error('Failed to fetch market', error);
                    market = Assistant.marketIfNotDetected;
                }
                setTimeout(() => this.submitted = false, 2000);
            }

            useCart().domain = this.answers.domainAndMarket.domain;
            useCart().market = market;

            window.location.href = `/${market}/${domain}?assistant=${this.answers.marketing}`;
        },
    },
}
</script>
