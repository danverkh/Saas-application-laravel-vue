<template>
    <Modal name="preview-rank" classes="max-w-2xl px-10 py-8 relative" @closed="onClose">
        <div class="alert text-xs mb-6">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current text-primary flex-shrink-0 w-6 h-6 mx-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>
                    This is a preview how the search results would likely look like with AutoRanker.
                    Forecasted results are directional estimates and do not guarantee performance.
                </span>
            </div>
        </div>

        <div class="search-field flex flex-nowrap justify-between items-center w-full mt-3 mb-10">
            <div>{{ keyword }}</div>

            <div class="flex flex-nowrap items-center gap-x-4">
                <div class="line h-5 bg-zinc-300"></div>

                <svg width="24" height="24" viewBox="0 0 512 512" class="text-[#4285F4]">
                    <path d="M344.5 298c15-23.6 23.8-51.6 23.8-81.7 0-84.1-68.1-152.3-152.1-152.3C132.1 64 64 132.2 64 216.3c0 84.1 68.1 152.3 152.1 152.3 30.5 0 58.9-9 82.7-24.4l6.9-4.8L414.3 448l33.7-34.3-108.5-108.6 5-7.1zm-43.1-166.8c22.7 22.7 35.2 52.9 35.2 85s-12.5 62.3-35.2 85c-22.7 22.7-52.9 35.2-85 35.2s-62.3-12.5-85-35.2c-22.7-22.7-35.2-52.9-35.2-85s12.5-62.3 35.2-85c22.7-22.7 52.9-35.2 85-35.2s62.3 12.5 85 35.2z" fill="currentColor"/>
                </svg>
            </div>
        </div>

        <div class="absolute z-10 top-0 bottom-0 left-0 right-0 select-none pointer-events-none">
            <div ref="heatmap" class="w-full h-full"></div>
        </div>

        <div v-if="results.length">
            <div>
                <div v-for="(result, index) in results" :key="`preview-rank-item-${index}`" class="mb-6 last:mb-0">
                    <div v-if="result.type === 'ad'">
                        <div v-for="n in Random.item([1, 3])" :key="`ad-${n}`" class="ad-item py-3 pointer-events-none select-none relative">
                            <div class="flex">
                                <div class="link text-lg text-blue-700 mb-2 blur-[5px] capitalize">{{ Random.words(3, 8) }}</div>
                                <div class="px-2 h-7 leading-7 bg-green-600 text-xs text-white rounded-lg ml-3">Ad</div>
                            </div>
                            <div class="description text-sm text-zinc-600 blur-[5px]">{{ Random.sentences(3, 4) }}</div>
                        </div>
                    </div>

                    <div v-else class="result-item">
                        <div class="text-sm mb-1 text-zinc-500 text-sm">
                            <span class="text-zinc-900">{{ breadcrumbDomain(result.breadcrumb) }}</span>
                            <span v-if="result.breadcrumb.includes('›')"> › {{ breadcrumbs(result.breadcrumb) }}</span>
                        </div>
                        <a :href="result.url" target="_blank" class="link text-lg text-blue-700 mb-2 cursor-pointer no-underline hover:underline hover:decoration-2">{{
                                result.title
                            }}</a>
                        <div class="description text-sm text-zinc-600">
                            {{
                                (result.description.length > descriptionLimit) ? result.description.substring(0, descriptionLimit) + '...' : result.description
                            }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 -mb-3">
                <svg width="40" height="40" viewBox="0 0 24 24" class="inline-block text-zinc-700">
                    <path fill="currentColor" d="M16 12a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2Z"/>
                </svg>
            </div>
        </div>

        <div v-else class="text-center py-12">
            <Spinner></Spinner>
        </div>
    </Modal>
</template>

<script>
import {usePreviewRankStore} from '@/stores/previewRank';
import Modal from "@/components/Modal.vue";
import Spinner from "@/components/Spinner.vue";
import Random from "@/services/Random";
import h337 from '@mars3d/heatmap.js';
import generator from "random-seed";

export default {
    name: 'PreviewRankModal',

    components: {Spinner, Modal},

    data() {
        return {
            descriptionLimit: 220,
            Random: Random,
            heatmapInstance: null,
        };
    },

    watch: {
        results(items) {
            if (items.length) {
                this.$nextTick(() => {
                    const config = {
                        container: this.$refs.heatmap,
                        radius: 80,
                        maxOpacity: .2,
                        minOpacity: 0,
                        blur: .8,
                    };

                    this.heatmapInstance = h337.create(config);

                    this.heatmapInstance.setData(
                        this.getHeatData()
                    );
                });
            }
        },
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

        onClose() {
            usePreviewRankStore().abortFetch();
            this.heatmapInstance.setData({max: 10, data: []});

            delete this.heatmapInstance;
            document.querySelector('.heatmap-canvas').remove();
        },

        getHeatData() {
            const random = generator(this.keyword);
            const points = [];

            document.querySelectorAll('.ad-item')
                .forEach(ad => {
                    const adLinkBounds = ad.querySelector('.link').getBoundingClientRect();

                    let count = random.intBetween(3, 10);

                    for (let i = 0; i < count; i++) {
                        points.push({
                            x: random.intBetween(0, adLinkBounds.width) + 50,
                            y: random.intBetween(ad.offsetTop, (ad.offsetTop + adLinkBounds.height)) + 15,
                            value: random.intBetween(2, 8),
                        });
                    }
                });

            const resultLinks = document.querySelectorAll('.result-item .link');

            resultLinks.forEach((resultLink, index) => {
                    const num = Math.abs(resultLinks.length - index) * 5;
                    const resultLinkBounds = resultLink.getBoundingClientRect();

                    let count = random.intBetween(num - resultLinks.length, num + 5);

                    for (let i = 0; i < count; i++) {
                        points.push({
                            x: random.intBetween(0, resultLinkBounds.width) + 50,
                            y: random.intBetween(resultLink.offsetTop, (resultLink.offsetTop + resultLinkBounds.height)),
                            value: random.intBetween(3, 10),
                        });
                    }
                });

            return {max: 10, data: points};
        },
    },
}
</script>

<style scoped>
.search-field {
    height: 55px;
    background: #fff;
    box-shadow: 0 2px 5px 1px rgb(65 60 67 / 20%);
    border-radius: 12px;
    color: rgba(0, 0, 0, .87);
    line-height: 55px;
    padding: 0 18px;
}

.line {
    width: 1px;
}

.link {
    font-size: 20px;
    font-weight: 400;
    line-height: 1.3;
}

.description {
    line-height: 1.6;
    font-size: 14px;
}
</style>
