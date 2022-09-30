<template>
    <OnClickOutside @trigger="close" class="relative">
        <input v-model="domain"
               v-bind="$attrs"
               @input="debouncedFetch"
               @focus="open"
               @keyup.enter="selectOrSearch"
               @keydown.up.prevent="moveSelectionUp"
               @keydown.down.prevent="moveSelectionDown"
               @keydown.ctrl.space="open"
               @keyup.esc="close"
               type="text"
               ref="searchRef"
               placeholder="Please enter a domain here..."
               class="main-search input input-lg h-[60px] w-full ring-1 ring-gray-300 px-4 md:px-6 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"/>

        <ul v-if="suggestionsOpened"
            class="absolute top-[70px] w-full bg-white border border-zinc-200 rounded-lg shadow-lg divide-y divide-zinc-200 overflow-hidden">

            <li v-for="(item, index) in items"
                :key="`suggestion-${index}`"
                @click="selectSuggestion(index)"
                class="group flex items-center px-4 py-4 cursor-pointer"
                :class="{
                        'hover:bg-zinc-100': index !== index,
                        'bg-blue-50/75 text-zinc-900 hover:bg-blue-50': isActive(item, index),
                        'bg-primary-50/20 text-primary hover:bg-primary-50/20': isSelected(item, index),
                        'bg-blue-50/75 text-primary hover:bg-primary-50/40 hover:text-primary': isActiveAndSelected(item, index),
                    }">

                <svg class="w-5 h-5 mr-4"
                     :class="{
                            'group-hover:text-zinc-900': index !== index,
                            'text-zinc-900': isActive(item, index),
                            'text-primary/90 group-hover:text-primary/90': isSelected(item, index),
                            'text-primary': isActiveAndSelected(item, index),
                         }"
                     viewBox="0 0 24 24">
                    <path fill="currentColor" d="M16.36 14c.08-.66.14-1.32.14-2c0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2m-5.15 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 0 1-4.33 3.56M14.34 14H9.66c-.1-.66-.16-1.32-.16-2c0-.68.06-1.35.16-2h4.68c.09.65.16 1.32.16 2c0 .68-.07 1.34-.16 2M12 19.96c-.83-1.2-1.5-2.53-1.91-3.96h3.82c-.41 1.43-1.08 2.76-1.91 3.96M8 8H5.08A7.923 7.923 0 0 1 9.4 4.44C8.8 5.55 8.35 6.75 8 8m-2.92 8H8c.35 1.25.8 2.45 1.4 3.56A8.008 8.008 0 0 1 5.08 16m-.82-2C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2c0 .68.06 1.34.14 2M12 4.03c.83 1.2 1.5 2.54 1.91 3.97h-3.82c.41-1.43 1.08-2.77 1.91-3.97M18.92 8h-2.95a15.65 15.65 0 0 0-1.38-3.56c1.84.63 3.37 1.9 4.33 3.56M12 2C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2Z"/>
                </svg>
                {{ item.mail_domain }}
            </li>
        </ul>
    </OnClickOutside>
</template>

<script>
import {OnClickOutside} from '@vueuse/components';
import {debounce} from "lodash";

export default {
    name: "AutoSuggest",

    inheritAttrs: false,

    components: {OnClickOutside},

    data() {
        return {
            index: 0,
            show: false,
            items: [],
            debouncedFetch: null,
        };
    },

    computed: {
        suggestionsOpened() {
            return this.show && this.items.length;
        },
    },

    created() {
        this.debouncedFetch = debounce(() => {
            if (this.domain.length < 3) {
                return;
            }
            axios.get(route('api.autosuggest.domain'), {params: {domain: this.domain, market: this.market}})
                .then(({data}) => {
                    this.index = -1;
                    this.items = data.suggestions;
                    this.open();
                })
                .catch(e => console.error('Failed to fetch suggestions', e));
        }, 500);
    },

    methods: {
        selectSuggestion(index) {
            this.domain = this.items[index].mail_domain;
            this.close();
        },

        moveSelectionUp() {
            if (this.index > -1) {
                this.index--;
            }
        },

        moveSelectionDown() {
            if (!this.suggestionsOpened) {
                this.open();
                return;
            }
            if (this.index < (this.items.length - 1)) {
                this.index++;
            }
        },

        open() {
            if (this.items.length) {
                this.show = true;
            }
        },

        close() {
            this.show = false;
        },

        isSelected(item, index) {
            return index !== this.index && item.mail_domain === this.domain;
        },

        isActiveAndSelected(item, index) {
            return index === this.index && item.mail_domain === this.domain;
        },

        isActive(item, index) {
            return index === this.index && item.mail_domain !== this.domain;
        },
    },
}
</script>
