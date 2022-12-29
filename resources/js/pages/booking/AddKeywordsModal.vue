<template>
    <Modal name="add-keywords-modal" classes="max-w-lg px-6 sm:px-8 py-7 sm:py-8">
        <div class="text-2xl text-center mb-5">Add your own keywords</div>

        <div class="flex flex-col gap-y-6">
            <div>
                <div class="flex flex-nowrap gap-4">
                    <Input @keyup.enter="addKeyword"
                           v-model="keyword"
                           placeholder="Keyword"
                           ref="keyword"
                           :error="keyword.length > 0 && !keywordIsValid"
                           :error-text="false"
                           class="text-zinc-900 text-base"/>

                    <button @click="addKeyword" class="btn btn-square" :class="{'pointer-events-none cursor-default opacity-50': !keywordIsValid}">
                        <svg class="h-6 w-6" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M11 19v-6H5v-2h6V5h2v6h6v2h-6v6Z"/></svg>
                    </button>
                </div>

                <div v-if="keywordWasAlreadyAdded" class="text-xs text-red-600 mt-2">keyword was already added</div>
                <div v-if="keywordExistsInTheTable" class="text-xs text-red-600 mt-2">keyword already exists</div>
            </div>

            <div v-if="keywords.length" class="border border-gray-200 rounded-lg">
                <table class="table table-zebra w-full">
                    <tbody>
                        <tr v-for="(keywordItem, index) in keywords" :key="`keyword-${index}`" class="border-b border-gray-200 last:border-b-0">
                            <td class="p-2 pl-4 text-sm font-semibold whitespace-normal w-2/3 overflow-hidden" :class="{'!bg-accent !bg-opacity-10': keywordItem.value === keyword}">
                                {{ keywordItem.value }}
                            </td>
                            <td class="px-2 text-right" :class="{'!bg-accent !bg-opacity-10': keywordItem.value === keyword}">
                                <div v-if="keywordItem.requestPending" class="flex">
                                    <Spinner :size="16" :border-width="3" color="#3d83f6" class="-mb-0.5 mr-2"/>
                                </div>

                                <div v-else>
                                    <div v-if="keywordItem.status === 'possible'" class="badge badge-success gap-1 text-xs p-3">
                                        <svg class="inline-block w-4 h-4 stroke-current -ml-0.5" width="32" height="32" viewBox="0 0 32 32"><path fill="currentColor" d="m13 24l-9-9l1.414-1.414L13 21.171L26.586 7.586L28 9L13 24z"/></svg>
                                        possible
                                    </div>

                                    <div v-else-if="keywordItem.status === 'not_possible'" class="badge badge-warning gap-1 text-xs p-3">
                                        <span class="mr-1">✕</span>
                                        not possible
                                    </div>

                                    <div v-else-if="keywordItem.status === 'failed'" class="badge badge-error gap-1 text-xs p-3">
                                        <span class="mr-1">✕</span>
                                        failed
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 pr-4" :class="{'!bg-accent !bg-opacity-10': keywordItem.value === keyword}">
                                <svg @click="removeKeyword(index)" class="h-4 w-4 text-red-600 cursor-pointer" width="32" height="32" viewBox="0 0 24 24"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11 5a1 1 0 0 0-1 1h4a1 1 0 0 0-1-1h-2zm0-2a3 3 0 0 0-3 3H4a1 1 0 0 0 0 2h1v10a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 1 0 0-2h-4a3 3 0 0 0-3-3h-2zm0 8a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0v-5zm4 0a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0v-5z" fill="currentColor"/></g></svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="text-sm text-center text-accent bg-accent bg-opacity-10 p-4 rounded-lg">Please add at least one keyword</div>

            <div class="bg-zinc-100 border-t border-t-zinc-200 mt-2 -mx-6 sm:-mx-8 -mb-7 sm:-mb-8">
                <div class="flex justify-end px-6 sm:px-8 py-5 sm:py-5">
                    <SubmitButton @click="submit" class="!py-3 w-full !pl-5 sm:w-[210px]" :disabled="!canSubmitKeywords || submittingKeywords">
                        <Spinner v-if="submittingKeywords" color="#fff" :size="22" :border-width="4"></Spinner>
                        <span v-else>Add keywords</span>
                    </SubmitButton>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/components/Modal.vue";
import ModalService from "@/services/Modal";
import Spinner from "@/components/Spinner.vue";
import Input from "@/components/Input.vue";
import SubmitButton from "@/components/SubmitButton.vue";
import {useRankingItemsStore} from "@/stores/rankingItems";
import axios from "axios";
import {useCart} from "@/stores/cart";

export default {
    name: 'AddKeywordsModal',

    components: {SubmitButton, Input, Spinner, Modal},

    data() {
        return {
            keyword: '',
            keywords: [],
            maxRetry: 2,
            submittingKeywords: false,
        };
    },

    computed: {
        keywordIsValid() {
            return this.keyword.length > 2
                && !this.keywordWasAlreadyAdded
                && !this.keywordExistsInTheTable
                && this.keywords.length < 10;
        },

        keywordWasAlreadyAdded() {
            return this.keywords.find(i => i === this.keyword) !== undefined;
        },

        keywordExistsInTheTable() {
            return useRankingItemsStore().contains(this.keyword);
        },

        canSubmitKeywords() {
            return this.keywords.some(i => i.status === 'possible');
        },
    },

    methods: {
        addKeyword() {
            if (this.keywordIsValid) {
                this.keywords.push({
                    value: this.keyword,
                    status: 'new',
                    requestPending: false,
                    retry: 0,
                });
                this.keyword = '';
                this.$refs.keyword.focus();

                this.validateKeyword(this.keywords[this.keywords.length - 1]);
            }
        },

        removeKeyword(index) {
            this.keywords.splice(index, 1);
        },

        validateKeyword(keyword) {
            const params = {
                market: useCart().market,
                domain: useCart().domain,
                keyword: keyword.value,
            };

            keyword.requestPending = true;

            axios.get(route('api.keyword.validate'), {params})
                .then(({data}) => {
                    keyword.status = data.result;
                    keyword.data = data.data;

                    keyword.requestPending = false;
                })
                .catch(error => {
                    console.error('Failed to validate keyword', error);

                    // retry
                    if (keyword.retry < this.maxRetry) {
                        keyword.retry++;
                        this.validateKeyword(keyword);
                    } else {
                        keyword.status = 'failed';
                        keyword.requestPending = false;
                    }
                });
        },

        submit() {
            this.submittingKeywords = true;

            setTimeout(() => {
                this.keywords.forEach(keyword => {
                    if (keyword.status === 'possible') {
                        useRankingItemsStore().items.unshift({
                            competition: null,
                            cpc: keyword.data.cpc,
                            current_rank: '-',
                            keyword: keyword.value,
                            maximum_cost: keyword.data.maximum_cost,
                            projected_clicks: keyword.data.projected_clicks,
                            projected_traffic: keyword.data.projected_traffic,
                            search_volume: keyword.data.search_volume,
                            selected: false,
                            traffic_cost: null,
                            url: '-',
                        });

                        useRankingItemsStore().add(useRankingItemsStore().items[0]);
                        useRankingItemsStore().addUserAddedItem(useRankingItemsStore().items[0]);
                    }
                });

                this.keywords = this.keywords.filter(i => i.status !== 'possible');

                ModalService.close('add-keywords-modal');

                this.submittingKeywords = false;
            }, 200);
        },
    },
}
</script>
