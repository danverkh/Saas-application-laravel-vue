<template>
    <Modal name="preview-rank" classes="max-w-2xl p-10" @closed="abortFetch">
        <div class="search-field flex flex-nowrap justify-between items-center w-full mt-3 mb-10">
            <div>{{ keyword }}</div>

            <div class="flex flex-nowrap items-center gap-x-4">
                <svg width="24" height="24" viewBox="0 0 24 24" class="text-zinc-500">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.758 17.243L12.001 12m5.243-5.243L12 12m0 0L6.758 6.757M12.001 12l5.243 5.243"/>
                </svg>

                <div class="line h-5 bg-zinc-300"></div>

                <svg width="24" height="24" viewBox="0 0 512 512" class="text-[#4285F4]">
                    <path d="M344.5 298c15-23.6 23.8-51.6 23.8-81.7 0-84.1-68.1-152.3-152.1-152.3C132.1 64 64 132.2 64 216.3c0 84.1 68.1 152.3 152.1 152.3 30.5 0 58.9-9 82.7-24.4l6.9-4.8L414.3 448l33.7-34.3-108.5-108.6 5-7.1zm-43.1-166.8c22.7 22.7 35.2 52.9 35.2 85s-12.5 62.3-35.2 85c-22.7 22.7-52.9 35.2-85 35.2s-62.3-12.5-85-35.2c-22.7-22.7-35.2-52.9-35.2-85s12.5-62.3 35.2-85c22.7-22.7 52.9-35.2 85-35.2s62.3 12.5 85 35.2z" fill="currentColor"/>
                </svg>
            </div>
        </div>

        <template v-if="results.length">
            <div>
                <div v-for="(result, index) in results" :key="`preview-rank-item-${index}`" class="mb-6 last:mb-0">
                    <div class="breadcrumb text-sm mb-1">
                        <span class="domain">{{ breadcrumbDomain(result.breadcrumb) }}</span>
                        <span v-if="result.breadcrumb.includes('›')"> › {{ breadcrumbs(result.breadcrumb) }}</span>
                    </div>
                    <div class="link text-lg mb-1 no-underline hover:underline hover:decoration-2">{{ result.title }}</div>
                    <div class="description text-sm">
                        {{ (result.description.length > descriptionLimit) ? result.description.substring(0, descriptionLimit) + '...' : result.description }}
                    </div>
                </div>
            </div>

            <div class="text-center mt-2 -mb-2">
                <svg width="40" height="40" viewBox="0 0 24 24" class="inline-block text-zinc-700">
                    <path fill="currentColor" d="M16 12a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2Z"/>
                </svg>
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

    data() {
        return {
            descriptionLimit: 220,
        };
    },

    computed: {
        keyword() {
            return usePreviewRankStore().keyword;
        },

        results() {
            return usePreviewRankStore().results;
        },
    },

    methods: {
        breadcrumbDomain(breadcrumb) {
            return breadcrumb.split(' › ')[0];
        },

        breadcrumbs(breadcrumb) {
            const parts = breadcrumb.split(' › ');
            parts.shift();
            return parts.join(' › ');
        },

        abortFetch() {
            usePreviewRankStore().abortFetch();
        },
    },
}
</script>

<style scoped>
.search-field {
    height: 44px;
    background: #fff;
    border: 1px solid transparent;
    box-shadow: 0 2px 5px 1px rgb(64 60 67 / 16%);
    border-radius: 24px;
    color: rgba(0,0,0,.87);
    font: 16px arial,sans-serif;
    line-height: 44px;
    padding: 0 20px;
}

.line {
    width: 1px;
}

.breadcrumb {
    color: #5f6368;
    font-family: arial,sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: normal;
    line-height: 1.3;
}
.domain {
    color: #202124;
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
