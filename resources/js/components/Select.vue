<template>
    <div class="flex flex-col flex-nowrap w-full" :class="containerClass">
        <select @input="$emit('update:modelValue', $event.target.value)"
                :value="modelValue"
                class="select w-full text-zinc-900 text-base font-medium invalid:text-zinc-400 ring-1 ring-gray-300 px-4 py-1 hover:ring-2
                   hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"
                :class="{'bg-gray-50 text-gray-600': disabled || readonly, 'ring-red-500/50': error}"
                v-bind="$attrs"
                required>

            <option value="" disabled selected>Select</option>

            <option v-for="option in options" :key="`select-option-${option.value}`" :value="option.value">{{ option.label }}</option>
        </select>
        <div v-if="error" class="validation-error text-sm text-red-600 mt-2">{{ error[0] }}</div>
    </div>
</template>

<script>
export default {
    name: "Select",

    inheritAttrs: false,

    emits: ['update:modelValue'],

    props: {
        modelValue: null,
        options: {
            type: Array,
            default: () => ([]),
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
}
</script>
