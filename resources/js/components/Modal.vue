<template>
    <Teleport to="body">
        <input type="checkbox" ref="modalCheckbox" v-model="opened" :id="name" class="modal-toggle" @change="stateChanged"/>
        <label :for="name" class="modal py-10 overflow-y-auto" @click="close">
            <div class="modal-box max-h-max m-auto" :class="[classes, width, overflow]">
                <label :for="name" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-50 hover:text-primary hover:bg-primary-50/50">✕</label>
                <h3 v-if="title" class="text-lg font-bold" :class="[titleClass]">{{ title }}</h3>

                <slot></slot>
            </div>
        </label>
    </Teleport>
</template>

<script>
export default {
    name: "Modal",

    emits: ['opened', 'closed'],

    props: {
        name: String,
        title: String,
        width: String,
        titleClass: String,
        classes: String,
        overflow: {
            type: String,
            default: 'overflow-y-auto',
        },
    },

    inheritAttrs: false,

    data() {
        return {
            opened: false,
        };
    },

    mounted() {
        document.addEventListener('keyup', event => {
            if (this.opened && event.key === 'Escape') {
                this.opened = false;
                this.$emit('closed');
            }
        });
    },

    methods: {
        stateChanged(event) {
            if (event.target.checked) this.$emit('opened');
        },

        close(event) {
            if (event.target.nodeName !== 'LABEL' && event.target.className !== 'modal') {
                if (event.target.nodeName !== 'A') {
                    event.preventDefault();
                }
            } else {
                this.$emit('closed');
            }
        },
    },
}
</script>
