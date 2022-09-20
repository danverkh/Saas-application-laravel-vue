<template>
    <div class="flex flex-col flex-nowrap w-full" :class="containerClass">
        <textarea @input="$emit('update:modelValue', $event.target.value)"
                  :value="modelValue"
                  v-bind="$attrs"
                  :rows="rows"
                  :class="{'bg-gray-50 text-gray-600': disabled || readonly, 'ring-red-500/50': error}"
                  :readonly="disabled || readonly"
                  class="textarea text-zinc-900 text-base ring-1 ring-gray-300 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"></textarea>

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
        rows: {
            default: 3,
            type: Number,
        },
        error: {
            default: null,
        },
    },

    emits: ['update:modelValue'],
})
</script>
