<template>
    <Modal name="add-keywords-modal" classes="max-w-md px-10 py-9" @closed="clearKeywords">
        <div class="text-2xl text-center mb-5">Add your own keywords</div>

        <div class="flex flex-col gap-y-6">
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

            <div class="border border-gray-200 rounded-lg">
                <div v-if="keywords.length">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <tbody>
                                <tr v-for="(keyword, index) in keywords" :key="`keyword-${index}`">
                                    <th class="py-2">{{ index + 1 }}.</th>
                                    <td class="py-2 w-full">{{ keyword }}</td>
                                    <td class="py-2">
                                        <svg @click="removeKeyword(index)" class="h-4 w-4 text-red-600 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-else class="text-center bg-accent bg-opacity-10 p-4">
                    Please add at least one keyword
                </div>
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

export default {
    name: 'AddKeywordsModal',

    components: {SubmitButton, Input, Spinner, Modal},

    data() {
        return {
            keyword: '',
            keywords: [],
        };
    },

    computed: {
        keywordIsValid() {
            return this.keyword.length > 2 && !this.keywords.find(i => i === this.keyword);
        },
    },

    methods: {
        addKeyword() {
            if (this.keywordIsValid) {
                this.keywords.push(this.keyword);
                this.keyword = '';
                this.$refs.keyword.focus();
            }
        },

        removeKeyword(index) {
            this.keywords.splice(index, 1);
        },

        clearKeywords() {
            this.keywords = [];
        },

        submit() {
            alert('Not implemented');
        },
    },
}
</script>
