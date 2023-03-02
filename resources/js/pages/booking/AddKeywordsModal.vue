<template>
    <Modal name="add-keywords-modal" classes="max-w-lg px-6 sm:px-8 py-7 sm:py-8">
        <div class="text-2xl text-center mb-5">Add your own keyword</div>

        <div class="flex flex-col gap-y-6">
            <div>
                <div class="flex flex-nowrap gap-4">
                    <Input @keyup.enter="submit"
                           @change="checkIfKeywordExistsInTheTable"
                           v-model="keyword"
                           placeholder="Keyword"
                           ref="keyword"
                           :error="keyword.length > 0 && !keywordIsValid"
                           :error-text="false"
                           class="text-zinc-900 text-base"/>
                </div>

                <div v-if="keywordWasAlreadyAdded" class="text-sm text-red-600 mt-2">keyword was already added</div>
                <div v-if="keywordExistsInTheTable" class="text-sm text-red-600 mt-2">keyword already exists</div>
            </div>

            <div class="bg-zinc-100 border-t border-t-zinc-200 mt-2 -mx-6 sm:-mx-8 -mb-7 sm:-mb-8">
                <div class="flex justify-end px-6 sm:px-8 py-5 sm:py-5">
                    <SubmitButton @click="submit" class="!py-3 w-full !pl-5 sm:w-[180px]" :disabled="!keywordIsValid || addingKeyword">
                        Add keyword
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
import CustomUserKeyword from "@/services/CustomUserKeyword";

export default {
    name: 'AddKeywordsModal',

    components: {SubmitButton, Input, Spinner, Modal},

    data() {
        return {
            keyword: '',
            addingKeyword: false,
            keywordExistsInTheTable: false,
        };
    },

    computed: {
        keywordIsValid() {
            return this.keyword.length > 2
                && !this.keywordWasAlreadyAdded
                && !this.keywordExistsInTheTable;
        },

        keywordWasAlreadyAdded() {
            return false; //this.keywords.find(i => i === this.keyword) !== undefined;
        },
    },

    methods: {
        checkIfKeywordExistsInTheTable() {
            this.keywordExistsInTheTable = useRankingItemsStore().contains(this.keyword);
        },

        submit() {
            this.addingKeyword = true;

            setTimeout(() => {
                useRankingItemsStore().items.push({
                    keyword: this.keyword,
                    competition: null,
                    cpc: null,
                    current_rank: '-',
                    maximum_cost: null,
                    projected_clicks: null,
                    projected_traffic: null,
                    search_volume: null,
                    selected: false,
                    traffic_cost: null,
                    url: '-',

                    status: 'new',
                    requestPending: false,
                    retry: 0,
                });

                const length = useRankingItemsStore().items.length - 1;

                CustomUserKeyword.validateKeyword(useRankingItemsStore().items[length]);

                useRankingItemsStore().addUserAddedItem(useRankingItemsStore().items[length]);

                // it is faster to push and reorder then to use unshift
                useRankingItemsStore().reorderItems();

                this.keyword = '';
                this.addingKeyword = false;

                ModalService.close('add-keywords-modal');
            }, 200);
        },
    },
}
</script>
