<template>

    <transition-group name="list">
        <div v-for="(item, index) in items" :key="`success-story-${index}`" :style="{'--i': index}">
            <success-story :item="item"></success-story>
        </div>
    </transition-group>

    <div v-if="!reachedEnd" class="my-16 grid place-content-center">
        <div v-if="!requestPending" class="btn btn-lg" @click="fetch">
            More Stories
        </div>

        <spinner v-else :size="40" :border-width="6"></spinner>
    </div>

    <div v-if="reachedEnd" class="my-16 text-center text-lg text-zinc-400 tracking-wide select-none">
        All stories were loaded
    </div>
</template>

<script>
import Spinner from "@/components/Spinner.vue";

export default {
    name: "ShowMoreButton",

    components: {Spinner},

    data() {
        return {
            page: 1,
            reachedEnd: false,
            requestPending: false,
            items: [],
        };
    },

    methods: {
        fetch() {
            if (this.requestPending) {
                return;
            }
            this.requestPending = true;

            axios.get(route('api.success_stories.fetch'), {params: {page: this.page + 1}})
                .then(({data}) => {
                    this.page++;

                    this.items      = [...this.items, ...data.items];
                    this.reachedEnd = data.reachedEnd;
                })
                .catch(error => {
                    console.error(error);
                    GlobalNotification.error('Whoops, something went wrong', 'Failed to fetch more success stories');
                })
                .finally(() => {
                    this.requestPending = false;
                });
        },
    },
}
</script>

<style scoped>
.list-enter-active,
.list-leave-active {
    transition: all 0.6s ease-out;
    transition-delay: calc(0.3s * var(--i));
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(40px);
}
</style>
