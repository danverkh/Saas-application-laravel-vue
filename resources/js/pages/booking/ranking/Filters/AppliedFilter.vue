<template>
    <div class="inline-flex items-center m-0 px-2 py-2 pr-4 bg-zinc-100 hover:bg-zinc-300/40 rounded-full flex-grow-0 text-xs font-medium border border-zinc-200 hover:border-accent/25 transition-colors duration-300">
        <button class="btn btn-circle btn-ghost btn-xs mr-1 -ml-0.5" @click.stop="$emit('removed')">
            <svg class="w-4 h-4" width="32" height="32" viewBox="0 0 36 36"><path fill="currentColor" d="m19.41 18l8.29-8.29a1 1 0 0 0-1.41-1.41L18 16.59l-8.29-8.3a1 1 0 0 0-1.42 1.42l8.3 8.29l-8.3 8.29A1 1 0 1 0 9.7 27.7l8.3-8.29l8.29 8.29a1 1 0 0 0 1.41-1.41Z" class="clr-i-outline clr-i-outline-path-1"/><path fill="none" d="M0 0h36v36H0z"/></svg>
        </button>

        <div :class="['select-none', this.value ? 'cursor-pointer' : 'pointer-events-none']">
            <slot/>

            <span v-if="operator" class="mx-0.5">
                {{ operator === 'greater' ? '>' : '<' }}
            </span>

            <span v-if="value">{{ value }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "AppliedFilter",

    emits: ['removed'],

    props: {
        value: {
            default: null,
            type: Number,
        },
        operator: {
            default: null,
            type: String,
        },
    },
}
</script>
