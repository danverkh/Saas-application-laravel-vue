<template>
    <market-select @changed="market = $event" :selected="market" class="grow-0"></market-select>

    <div class="flex-1">
        <OnClickOutside @trigger="close" class="relative">
            <label class="block text-gray-500 mb-2 inline-block" @click="focusSearch">Domain</label>
            <input v-model="domain"
                   @input="suggestions.debouncedFetch"
                   @focus="open"
                   @keyup.enter="selectOrSearch"
                   @keydown.up.prevent="suggestions.index > -1 && suggestions.index--"
                   @keydown.down.prevent="moveSelectionDown"
                   @keydown.ctrl.space="open"
                   @keyup.esc="close"
                   type="text"
                   ref="searchRef"
                   placeholder="Please enter a domain here..."
                   :class="{'border-primary': invalid}"
                   class="main-search input input-lg h-[60px] w-full ring-1 ring-gray-300 px-4 md:px-6 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"/>

            <ul v-if="suggestionsOpened"
                class="absolute top-[100px] w-full bg-white border border-zinc-200 rounded-lg shadow-lg divide-y divide-zinc-200 overflow-hidden">

                <li v-for="(item, index) in suggestions.items"
                    :key="`suggestion-${index}`"
                    @click="selectSuggestion(index)"
                    class="group flex items-center px-4 py-4 cursor-pointer hover:bg-zinc-100 hover:text-primary"
                    :class="{
                        'font-semibold bg-primary-50/25 text-zinc-900': index !== suggestions.index && item.mail_domain === domain,
                        'font-semibold bg-primary-50/25 text-primary': index === suggestions.index && item.mail_domain === domain,
                        'bg-zinc-100 text-primary': index === suggestions.index && item.mail_domain !== domain,
                    }">

                    <svg class="w-5 h-5 text-primary/60 mr-4 group-hover:text-primary"
                         :class="{
                            'text-zinc-900': index !== suggestions.index && item.mail_domain === domain,
                            'text-primary': index === suggestions.index && item.mail_domain === domain,
                            'text-primary': index === suggestions.index && item.mail_domain !== domain,
                         }"
                         viewBox="0 0 24 24">
                        <path fill="currentColor" d="M16.36 14c.08-.66.14-1.32.14-2c0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2m-5.15 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 0 1-4.33 3.56M14.34 14H9.66c-.1-.66-.16-1.32-.16-2c0-.68.06-1.35.16-2h4.68c.09.65.16 1.32.16 2c0 .68-.07 1.34-.16 2M12 19.96c-.83-1.2-1.5-2.53-1.91-3.96h3.82c-.41 1.43-1.08 2.76-1.91 3.96M8 8H5.08A7.923 7.923 0 0 1 9.4 4.44C8.8 5.55 8.35 6.75 8 8m-2.92 8H8c.35 1.25.8 2.45 1.4 3.56A8.008 8.008 0 0 1 5.08 16m-.82-2C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2c0 .68.06 1.34.14 2M12 4.03c.83 1.2 1.5 2.54 1.91 3.97h-3.82c.41-1.43 1.08-2.77 1.91-3.97M18.92 8h-2.95a15.65 15.65 0 0 0-1.38-3.56c1.84.63 3.37 1.9 4.33 3.56M12 2C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2Z"/>
                    </svg>
                    {{ item.mail_domain }}
                </li>
            </ul>
        </OnClickOutside>
    </div>

    <div class="grow-0">
        <button @click="search" class="btn btn-lg no-animation gap-2 tracking-widest bg-gray-900 h-[62px] min-h-[62px] md:px-7 group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 md:-ml-1 group-hover:scale-105 transition-all">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd"/>
            </svg>
            <span class="md:ml-1 hidden md:inline">Search</span>
        </button>
    </div>
</template>

<script>
import MarketSelect from './MarketSelect.vue';
import {useCart} from "@/stores/cart";
import {OnClickOutside} from '@vueuse/components';
import {debounce} from "lodash";

export default {
    name: "MainSearch",

    components: {MarketSelect, OnClickOutside},

    data() {
        return {
            market: useCart().market || 'at',
            domain: '',
            invalid: false,

            suggestions: {
                index: 0,
                show: false,
                items: [],
                debouncedFetch: null,
            },
        };
    },

    computed: {
        suggestionsOpened() {
            return this.suggestions.show && this.suggestions.items.length;
        },
    },

    watch: {
        domain(value) {
            if (value.length > 0) {
                this.invalid = false;
            }
        },
    },

    created() {
        this.suggestions.debouncedFetch = debounce(() => {
            axios.get(route('api.autosuggest.domain'), {params: {domain: this.domain, market: this.market}})
                .then(({data}) => {
                    this.suggestions.items = data.suggestions;
                    this.open();
                })
                .catch(e => console.error('Failed to fetch domain suggestions', e));
        }, 500);
    },

    methods: {
        selectOrSearch() {
            if (this.suggestionsOpened && this.suggestions.index >= 0) {
                this.selectSuggestion(this.suggestions.index);
            } else {
                this.search();
            }
        },

        search() {
            if (this.domain.length === 0) {
                this.invalid = true;
            } else {
                const domain = encodeURIComponent(this.domain);

                useCart().market = this.market;

                window.location.href = `/${this.market}/${domain}`;
            }
        },

        selectSuggestion(index) {
            this.domain = this.suggestions.items[index].mail_domain;
            this.close();
        },

        moveSelectionDown() {
            if (!this.suggestionsOpened) {
                this.open();
                return;
            }
            if (this.suggestions.index < (suggestions.items.length - 1)) {
                suggestions.index++;
            }
        },

        open() {
            this.suggestions.show = true;
        },

        close() {
            this.suggestions.show = false;
        },

        focusSearch() {
            this.$refs.searchRef.focus();
        },
    },
}
</script>
