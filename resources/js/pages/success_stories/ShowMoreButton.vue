<template>
    <div class="my-16 grid place-content-center">
        <div v-if="!requestPending" class="btn btn-lg" @click="fetch">
            More Stories
        </div>

        <spinner v-else :size="40" :border-width="6"></spinner>
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
            perPage: 10,
            requestPending: false,
        };
    },

    methods: {
        fetch() {
            this.requestPending = true;

            const params = {
                page: ++this.page,
                perPage: this.perPage,
            };

            axios.get(route('api.success_stories.fetch'), {params})
                .then(({data}) => {
                    // todo
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
