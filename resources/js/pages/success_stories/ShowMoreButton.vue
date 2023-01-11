<template>
    <div v-for="(item, index) in items" :key="`success-story-${index}`">
        <success-story :item="item"></success-story>
    </div>

    <div v-if="!reachedEnd" class="my-16 grid place-content-center">
        <div v-if="!requestPending" class="btn btn-lg" @click="fetch">
            More Stories
        </div>

        <spinner v-else :size="40" :border-width="6"></spinner>
    </div>

    <div v-if="reachedEnd" class="my-16 text-center text-xl">
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
            this.requestPending = true;

            const params = {
                page: this.page + 1,
            };

            axios.get(route('api.success_stories.fetch'), {params})
                .then(({data}) => {
                    this.page++;

                    if (data.length) {
                        this.items = [...this.items, ...data];
                    } else {
                        this.reachedEnd = true;
                    }
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
