<template>
    <Teleport to="body">
        <input type="checkbox" :id="name" class="modal-toggle"/>
        <label :for="name" class="modal" @click="close">
            <div class="modal-box overflow-visible" :class="[width]">
                <label :for="name" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 hover:text-primary hover:bg-primary-50/50">✕</label>
                <h3 v-if="title" class="text-lg font-bold">{{ title }}</h3>

                <slot></slot>
            </div>
        </label>
    </Teleport>
</template>

<script>
export default {
    name: "Modal",

    props: {
        name: String,
        title: String,
        width: String,
    },

    inheritAttrs: false,

    methods: {
        close(event) {
            if (event.target.nodeName !== 'LABEL' && event.target.className !== 'modal') {
                event.preventDefault();
            }
        },
    },
}
</script>
