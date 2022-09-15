<template>
    <div class="flex flex-col flex-nowrap w-full" :class="containerClass">
        <input :type="type"
               class="input w-full text-lg ring-1 ring-gray-300 px-4 py-1 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"
               :class="{'bg-gray-50 text-gray-600': disabled || readonly, 'ring-red-500/50': error}"
               v-bind="$attrs"
               :disabled="disabled || readonly"
               :value="modelValue"
               @input="$emit('update:modelValue', $event.target.value)"
               ref="input"
               :readonly="disabled || readonly">

        <div v-if="error" class="validation-error text-sm text-red-600 mt-2">{{ error[0] }}</div>
    </div>
</template>

<script>
import {defineComponent} from 'vue';

export default defineComponent({
    name: 'Input',

    inheritAttrs: false,

    props: {
        modelValue: null,
        type: {
            default: 'text',
            type: String,
        },
        readonly: {
            default: false,
            type: Boolean,
        },
        disabled: {
            default: false,
            type: Boolean,
        },
        containerClass: {
            default: null,
            type: String,
        },
        error: {
            default: null,
        },
    },

    emits: ['update:modelValue'],

    methods: {
        focus() {
            this.$refs.input.focus()
        },
    },
})
</script>
