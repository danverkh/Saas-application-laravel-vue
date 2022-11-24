<template>
    <Modal name="add-keywords-modal" classes="max-w-md px-10 py-9">
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

            <div class="border border-gray-200 rounded-lg">
                <div v-if="keywords.length">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <tbody>
                                <tr v-for="(keywordItem, index) in keywords" :key="`keyword-${index}`" class="border-b border-gray-200 last:border-b-0">
                                    <td class="pl-6 py-2 w-full text-lg font-semibold" :class="{'!bg-accent !bg-opacity-10': keywordItem.value === keyword}">
                                        {{ keywordItem.value }}
                                    </td>
                                    <td>
                                        <div>
                                            <svg class="w-3 h-3" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m10 16.4l-4-4L7.4 11l2.6 2.6L16.6 7L18 8.4Z"/></svg>
                                            possible
                                        </div>

                                        <div v-if="keywordItem.requestPending" class="flex">
                                            <Spinner :size="16" :border-width="3" color="#3d83f6" class="-mb-0.5 mr-2"/>
                                        </div>

                                        <div v-else>
                                            <div v-if="keywordItem.status === 'possible'">
                                                <svg class="w-3 h-3" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m10 16.4l-4-4L7.4 11l2.6 2.6L16.6 7L18 8.4Z"/></svg>
                                                possible
                                            </div>

                                            <div v-else-if="keywordItem.status === 'not_possible'">
                                                not possible
                                            </div>

                                            <div v-else-if="keywordItem.status === 'failed'">
                                                failed
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2" :class="{'!bg-accent !bg-opacity-10': keywordItem.value === keyword}">
                                        <svg @click="removeKeyword(index)" class="h-4 w-4 text-red-600 cursor-pointer" width="32" height="32" viewBox="0 0 24 24"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11 5a1 1 0 0 0-1 1h4a1 1 0 0 0-1-1h-2zm0-2a3 3 0 0 0-3 3H4a1 1 0 0 0 0 2h1v10a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 1 0 0-2h-4a3 3 0 0 0-3-3h-2zm0 8a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0v-5zm4 0a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0v-5z" fill="currentColor"/></g></svg>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-else class="text-sm text-center bg-accent bg-opacity-10 p-4">Please add at least one keyword</div>
            </div>

            <SubmitButton @click="submit" class="!py-3" :disabled="!keywords.length">Submit</SubmitButton>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/components/Modal.vue";
import Spinner from "@/components/Spinner.vue";
import Input from "@/components/Input.vue";
import SubmitButton from "@/components/SubmitButton.vue";
import {useRankingItemsStore} from "@/stores/rankingItems";
import axios from "axios";
import {useCart} from "@/stores/cart";
import GlobalNotification from "@/services/GlobalNotification";

export default {
    name: 'AddKeywordsModal',

    components: {SubmitButton, Input, Spinner, Modal},

    data() {
        return {
            keyword: '',
            keywords: [],
            maxRetry: 2,
            requestPending: false,
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
                })
                .catch(error => {
                    console.error('Failed to validate keyword', error);

                    // retry
                    if (keyword.retry < this.maxRetry) {
                        keyword.retry++;
                        this.validateKeyword(keyword);
                    }
                    // GlobalNotification.error({title: 'Whoops, something went wrong', message: 'Please try again later.'});
                })
                .finally(() => keyword.requestPending = false);
        },

        submit() {
            this.requestPending = true;
        },
    },
}
</script>
