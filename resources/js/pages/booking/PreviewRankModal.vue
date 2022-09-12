<template>
    <Modal name="preview-rank" width="max-w-3xl">

    </Modal>
</template>

<script>
import {usePreviewRankStore} from '../../stores/previewRank';
import Modal from "../../components/Modal";

export default {
    name: 'PreviewRankModal',

    components: {Modal},

    data() {
        return {
            previewRank: usePreviewRankStore(),
        };
    },
}
</script>
