<template>
    <Modal name="assistant-modal" width="max-w-xl" overflow="overflow-visible">
        <div v-if="step === 1" class="w-full mb-8">
            <div class="text-3xl text-center py-4">What are your online<br class="hidden sm:inline"> marketing goals?</div>

            <div class="flex flex-col gap-y-3 mt-6">
                <div class="btn btn-block" @click="answers.marketing = 'conversions'" :class="answers.marketing === 'conversions' ? 'btn-primary' : 'btn-secondary btn-outline'">Conversions</div>
                <div class="btn btn-block" @click="answers.marketing = 'branding'" :class="answers.marketing === 'branding' ? 'btn-primary' : 'btn-secondary btn-outline'">Branding</div>
                <div class="btn btn-block" @click="answers.marketing = 'find employees'" :class="answers.marketing === 'find employees' ? 'btn-primary' : 'btn-secondary btn-outline'">Find employees</div>
            </div>
        </div>

        <div v-if="step === 2" class="w-full mb-8">
            <div class="text-3xl text-center py-4">Your Budget</div>

            <div class="flex flex-col gap-y-3 mt-6">
                <div class="btn btn-block" @click="answers.budget.selection = 'fixed'" :class="answers.budget.selection === 'fixed' ? 'btn-primary' : 'btn-secondary btn-outline'">I have a budget in mind</div>
                <div class="btn btn-block" @click="answers.budget.selection = 'result'" :class="answers.budget.selection === 'result' ? 'btn-primary' : 'btn-secondary btn-outline'">I want to see a certain result</div>
            </div>
        </div>

        <div v-if="step === 3" class="w-full mb-8">
            <div class="text-3xl text-center pt-4 pb-8">Your Budget</div>

            <div v-if="answers.budget.selection === 'fixed'">
                <div class="text-lg text-center px-10">Enter your budget here</div>

                <div class="mt-6">
                    <div class="form-control max-w-xs w-full mx-auto mb-12">
                        <label class="input-group input-group-lg">
                            <span class="ring-1 ring-zinc-300 px-6">€</span>
                            <Input @keyup.enter="nextStep"
                                   v-model.number="answers.budget.fixedAmount"
                                   placeholder="0.00"
                                   :error="answers.budget.fixedAmount !== null && !isNumber(answers.budget.fixedAmount)"
                                   :error-text="false"
                                   class="text-zinc-900 text-lg"/>
                        </label>
                    </div>
                </div>
            </div>

            <div v-else-if="answers.budget.selection === 'result'">
                <div class="text-lg text-center">Enter your expected conversions</div>

                <div class="mt-4 mb-8">
                    <div class="form-control max-w-xs w-full mx-auto">
                        <Input @keyup.enter="nextStep"
                               v-model.number="answers.budget.conversions"
                               placeholder="0"
                               :error="answers.budget.conversions !== null && !isNumber(answers.budget.conversions)"
                               :error-text="false"
                               class="text-zinc-900 text-lg text-center"/>
                    </div>
                </div>

                <div class="divider">OR</div>

                <div class="text-lg text-center mt-6">new website visitors per month</div>

                <div class="my-4">
                    <div class="form-control max-w-xs w-full mx-auto mb-9">
                        <Input @keyup.enter="nextStep"
                               v-model.number="answers.budget.newVisitors"
                               placeholder="0"
                               :error="answers.budget.newVisitors !== null && !isNumber(answers.budget.newVisitors)"
                               :error-text="false"
                               class="text-zinc-900 text-lg text-center"/>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="step === 4" class="w-full mb-8">
            <div class="text-3xl text-center py-4">Your domain and market</div>

            <div class="flex flex-no-wrap gap-5 relative z-10 mt-6">
                <MainSearch no-search
                            :submit-on-select="false"
                            @market="answers.domainAndMarket.market = $event"
                            @domain="answers.domainAndMarket.domain = $event"></MainSearch>
            </div>
        </div>

        <div class="flex justify-between bg-zinc-100 border-t border-zinc-200 -mx-6 -mb-6 px-6 py-5 rounded-b-3xl">
            <button @click="prevStep" class="btn gap-1 px-8" :class="[step === 1 ? 'pointer-events-none opacity-10' : 'opacity-40']">
                <svg class="h-6 w-6 rotate-180 -ml-2" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M10.02 6L8.61 7.41L13.19 12l-4.58 4.59L10.02 18l6-6l-6-6z"/></svg>
                Prev
            </button>

            <button @click="nextStep" class="btn gap-1 px-8" :class="[canGoNext ? 'opacity-40' : 'pointer-events-none opacity-10']">
                Next
                <svg class="h-6 w-6 -mr-2" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M10.02 6L8.61 7.41L13.19 12l-4.58 4.59L10.02 18l6-6l-6-6z"/></svg>
            </button>
        </div>
    </Modal>
</template>

<script>
import Modal from "./Modal.vue";
import ModalService from "../services/Modal";
import MainSearch from "@/pages/homepage/MainSearch.vue";
import isNumber from 'lodash/isNumber';

export default {
    name: "AssistantModal",

    components: {Modal, MainSearch},

    data() {
        return {
            step: 1,
            answers: {
                marketing: null,
                budget: {
                    selection: null,
                    fixedAmount: null,
                    conversions: null,
                    newVisitors: null,
                },
                domainAndMarket: {
                    domain: null,
                    market: null,
                },
            },
            isNumber,
        };
    },

    computed: {
        canGoNext() {
            if (this.step === 1 && this.answers.marketing !== null) {
                return true;
            }
            if (this.step === 2 && this.answers.budget.selection !== null) {
                return true;
            }
            if (this.step === 3 && (isNumber(this.answers.budget.fixedAmount) || isNumber(this.answers.budget.conversions) || isNumber(this.answers.budget.newVisitors))) {
                return true;
            }
            if (this.step === 4 && this.answers.domainAndMarket.market && this.answers.domainAndMarket.domain) {
                return true;
            }
            return false;
        },
    },

    mounted() {
        ModalService.open('assistant-modal');
    },

    methods: {
        prevStep() {
            this.step--;
        },

        nextStep() {
            this.step++;
        },
    },
}
</script>
