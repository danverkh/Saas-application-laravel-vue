<template>
    <Teleport to="body">
        <input type="checkbox" :id="name" class="modal-toggle"/>
        <label :for="name" class="modal py-10 overflow-y-auto" @click="close">
            <div class="modal-box max-h-max m-auto" :class="[classes, width, overflow]">
                <label :for="name" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-50 hover:text-primary hover:bg-primary-50/50">✕</label>
                <h3 v-if="title" class="text-lg font-bold">{{ title }}</h3>

                <slot></slot>
            </div>
        </label>
    </Teleport>
</template>

<script>
export default {
    name: "Modal",

    emits: ['closed'],

    props: {
        name: String,
        title: String,
        width: String,
        classes: String,
        overflow: {
            type: String,
            default: 'overflow-y-auto',
        },
    },

    inheritAttrs: false,

    methods: {
        close(event) {
            if (event.target.nodeName !== 'LABEL' && event.target.className !== 'modal') {
                event.preventDefault();
            } else {
                this.$emit('closed');
            }
        },
    },
}
</script>
