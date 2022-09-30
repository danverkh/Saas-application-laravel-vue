<template>
    <OnClickOutside @trigger="close" class="relative">
        <input :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value); debouncedFetch()"
               v-bind="$attrs"
               @focus="open"
               @keyup.enter="selectOrSubmit"
               @keydown.up.prevent="moveSelectionUp"
               @keydown.down.prevent="moveSelectionDown"
               @keydown.ctrl.space="open"
               @keyup.esc="close"
               ref="input"
               type="text"
               class="input input-lg h-[60px] w-full ring-1 ring-gray-300 px-4 md:px-6 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"/>

        <ul v-if="suggestionsOpened"
            class="absolute top-[70px] w-full bg-white border border-zinc-200 rounded-lg shadow-lg divide-y divide-zinc-200 overflow-hidden">

            <li v-for="(item, index) in items"
                :key="`suggestion-${index}`"
                @click="selectSuggestion(index)"
                class="group flex items-center px-4 py-3 cursor-pointer"
                :class="{
                        'hover:bg-zinc-100': state(item, index).isIdle(),
                        'bg-blue-50/75 text-zinc-900 hover:bg-blue-50': state(item, index).isActive(),
                        'bg-primary-50/20 text-primary hover:bg-primary-50/20': state(item, index).isSelected(),
                        'bg-blue-50/75 text-primary hover:bg-primary-50/40 hover:text-primary': state(item, index).isActiveAndSelected(),
                    }">

                <slot name="item" v-bind="{item, state: state(item, index)}"></slot>
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
    },

    components: {OnClickOutside},

    data() {
        return {
            activeIndex: 0,
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
            if (this.modelValue.length < 3) {
                return;
            }

            this.request()
                .then(({data}) => {
                    this.activeIndex = -1;
                    this.items       = data.suggestions;
                    this.open();
                })
                .catch(e => console.error('Failed to fetch suggestions', e));
        }, 500);
    },

    methods: {
        selectOrSubmit() {
            if (this.suggestionsOpened && this.activeIndex >= 0) {
                this.selectSuggestion(this.activeIndex);
            } else {
                this.$emit('submit');
            }
        },

        selectSuggestion(index) {
            this.$emit('update:modelValue', this.items[index][this.selectionProperty]);
            this.close();
        },

        moveSelectionUp() {
            if (this.activeIndex > -1) {
                this.activeIndex--;
            }
        },

        moveSelectionDown() {
            if (!this.suggestionsOpened) {
                this.open();
                return;
            }
            if (this.activeIndex < (this.items.length - 1)) {
                this.activeIndex++;
            }
        },

        open() {
            if (this.items.length) {
                this.show = true;
            }
        },

        close() {
            this.show = false;
            this.activeIndex = 0;
        },

        state(item, index) {
            return {
                isIdle: () => index !== this.activeIndex,
                isSelected: () => index !== this.activeIndex && item[this.selectionProperty] === this.modelValue,
                isActiveAndSelected: () => index === this.activeIndex && item[this.selectionProperty] === this.modelValue,
                isActive: () => index === this.activeIndex && item[this.selectionProperty] !== this.modelValue,
            };
        },

        focus() {
            this.$refs.input.focus();
        },
    },
}
</script>
