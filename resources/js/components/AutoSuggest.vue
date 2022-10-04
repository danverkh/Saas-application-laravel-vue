<template>
    <OnClickOutside @trigger="close" class="relative">
        <input :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value); debouncedFetch()"
               v-bind="$attrs"
               @focus="open"
               @focusout="close"
               @keyup.enter="selectOrSubmit"
               @keydown.up.prevent="moveSelectionUp"
               @keydown.down.prevent="moveSelectionDown"
               @keydown.ctrl.space="open"
               @keyup.esc="close"
               ref="input"
               type="text"
               class="input input-lg h-[60px] w-full ring-1 ring-gray-300 px-4 md:px-6 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"/>

        <Spinner v-if="fetching" class="absolute top-[18px] right-5" :size="22" :border-width="3"></Spinner>

        <ul v-if="suggestionsOpened"
            class="absolute top-[70px] w-full bg-white border border-zinc-200 rounded-lg shadow-lg divide-y divide-zinc-200 overflow-hidden">

            <li v-for="(item, index) in items"
                :key="`suggestion-${index}`"
                @click="selectSuggestion(index)"
                class="group flex items-center px-4 py-3 cursor-pointer"
                :class="{
                        'hover:bg-zinc-100': state(item, index).idle(),
                        'bg-zinc-100/75 text-zinc-900 hover:bg-zinc-100': state(item, index).active(),
                        'bg-primary-50/20 text-primary hover:bg-primary-50/20': state(item, index).selected(),
                        'bg-primary-50/30 text-primary hover:bg-primary-50/40 hover:text-primary': state(item, index).activeAndSelected(),
                    }">

                <slot name="item" v-bind="{item, state: state(item, index), highlightFound}"></slot>
            </li>
        </ul>
    </OnClickOutside>
</template>

<script>
import {OnClickOutside} from '@vueuse/components';
import {debounce} from "lodash";
import Spinner from "@/components/Spinner.vue";

export default {
    name: "AutoSuggest",

    inheritAttrs: false,

    emits: ['update:modelValue', 'submit'],

    props: {
        modelValue: {
            required: true,
            type: String,
            default: '',
        },
        selectionProperty: {
            required: true,
            type: String,
        },
        request: {
            required: true,
            type: Function,
        },
        initialSuggestions: {
            type: Array,
            default: () => [],
        },
        filterFetched: {
            type: Boolean,
            default: false,
        },
        limit: {
            type: Number,
            default: 4,
        },
    },

    components: {Spinner, OnClickOutside},

    data() {
        return {
            activeIndex: 0,
            show: false,
            items: [],
            fetchedItems: [],
            debouncedFetch: null,
            fetching: false,
            hasFetchedItems: false,
        };
    },

    computed: {
        suggestionsOpened() {
            return this.show && this.items.length;
        },
    },

    created() {
        this.debouncedFetch = debounce(() => {
            // 1. check if we can use initial suggestions
            if (this.modelValue.length < 3) {
                this.useInitialSuggestions();
                return;
            }

            // 2. check if we have enough results from the previous response
            if (this.filterFetched) {
                const foundItems = this.fetchedItems.filter(item => item[this.selectionProperty].startsWith(this.modelValue));

                if (this.hasFetchedItems && foundItems.length >= this.limit) {
                    this.items = foundItems.slice(0, this.limit);
                    return;
                }
            }

            // 3. otherwise fetch new
            this.fetchNew();
        }, 400);
    },

    methods: {
        fetchNew() {
            this.fetching = true;

            this.request()
                .then(({data}) => {
                    this.hasFetchedItems = true;
                    this.fetching        = false;
                    this.activeIndex     = -1;
                    this.fetchedItems    = data.suggestions;
                    this.items           = data.suggestions.splice(0, this.limit);
                    this.open();
                })
                .catch(e => console.error('Failed to fetch suggestions', e));
        },

        useInitialSuggestions() {
            const items = this.initialSuggestions.filter(domain => domain.startsWith(this.modelValue));

            if (items.length) {
                this.items       = items.slice(0, this.limit).map(i => ({[this.selectionProperty]: i}));
                this.activeIndex = -1;
                this.open();
            } else {
                this.close();
            }
        },

        selectOrSubmit() {
            if (this.suggestionsOpened && this.activeIndex >= 0) {
                this.selectSuggestion(this.activeIndex);
            } else {
                this.$emit('submit');
            }
        },

        selectSuggestion(index) {
            this.$emit('update:modelValue', this.items[index][this.selectionProperty]);
            this.activeIndex = index;
            this.focus();
            this.close();
        },

        moveSelectionUp() {
            if (!this.suggestionsOpened) {
                this.open();
            } else if (this.activeIndex > -1) {
                this.activeIndex--;
            }
        },

        moveSelectionDown() {
            if (!this.suggestionsOpened) {
                this.open();
            } else if (this.activeIndex < (this.items.length - 1)) {
                this.activeIndex++;
            }
        },

        highlightFound(text, segment) {
            return `<span class="font-semibold">${segment}</span>` + text.substr(segment.length);
        },

        open() {
            if (this.items.length) {
                this.show = true;
            }
        },

        close() {
            setTimeout(() => {
                this.show        = false;
                this.activeIndex = this.items.findIndex(i => i[this.selectionProperty] === this.modelValue);
            }, 100);
        },

        state(item, index) {
            return {
                idle: () => index !== this.activeIndex,
                active: () => index === this.activeIndex && item[this.selectionProperty] !== this.modelValue,
                selected: () => index !== this.activeIndex && item[this.selectionProperty] === this.modelValue,
                activeAndSelected: () => index === this.activeIndex && item[this.selectionProperty] === this.modelValue,
            };
        },

        focus() {
            this.$refs.input.focus();
        },

        clear() {
            this.$emit('update:modelValue', '');
            this.close();
            this.items = [];
        },
    },
}
</script>
