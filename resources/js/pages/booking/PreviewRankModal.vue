<template>
    <Modal name="preview-rank" classes="max-w-2xl p-10">
        <template v-if="results.length">
            <div v-for="(result, index) in results" :key="`preview-rank-item-${index}`" class="mb-6">
                <div class="breadcrumb text-sm mb-1">{{ result.breadcrumb }}</div>
                <div class="link text-lg mb-1 hover:underline decoration-2">{{ result.title }}</div>
                <div class="description text-sm">{{ result.description }}</div>
            </div>
        </template>

        <div v-else class="text-center py-12">
            <Spinner></Spinner>
        </div>
    </Modal>
</template>

<script>
import {usePreviewRankStore} from '../../stores/previewRank';
import Modal from "../../components/Modal.vue";
import Spinner from "../../components/Spinner.vue";

export default {
    name: 'PreviewRankModal',

    components: {Spinner, Modal},

    computed: {
        results() {
            return usePreviewRankStore().results;
        },
    },
}
</script>

<style scoped>
.breadcrumb {
    color: #5f6368;
    font-family: arial,sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: normal;
    line-height: 1.3;
}

.link {
    color: #1a0dab;
    font-family: arial,sans-serif;
    font-size: 20px;
    font-weight: 400;
    line-height: 1.3;
}

.description {
    color: #4d5156;
    line-height: 1.58;
    font-family: arial,sans-serif;
    font-size: 14px;
    font-weight: normal;
}
</style>
