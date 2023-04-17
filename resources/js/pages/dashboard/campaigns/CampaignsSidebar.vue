<template>
    <div v-for="(keywords, domain) in sidebarItems" :key="`sidebar-${domain}`" class="dropdown w-full py-2 space-y-1">
        <label
            @click="sliderStates[domain] = !sliderStates[domain]"
            :class="[
                'btn btn-ghost btn-block text-base normal-case break-all',
                Object.keys(keywords).find(k => keywords[k].keyword === selected.keyword) ? 'bg-primary hover:bg-primary text-white hover:text-zinc-200' : 'bg-zinc-100'
            ]"
        >
            {{ domain }}
        </label>
        <slide-up-down v-model="sliderStates[domain]" :duration="300" timing-function="ease-out">
            <button
                v-for="domainKeyword in keywords"
                :key="`sidebar-${domain}-${domainKeyword.keyword}`"
                :class="[
                    'btn btn-ghost btn-block text-sm text-left normal-case font-medium break-words h-auto py-2 justify-start',
                    (domainKeyword.keyword === selected.keyword) ? 'text-primary bg-zinc-100 font-semibold' : '',
                    domainKeyword.termination_date !== null ? 'text-zinc-300 hover:text-zinc-400' : '',
                ]"
                @click="fetchDomainKeyword(domainKeyword)"
            >
                <div class="w-full flex flex-row items-center justify-between gap-x-2">
                    <div class="grow">{{ domainKeyword.keyword }}</div>
                    <div v-if="domainKeyword.termination_date !== null" class="tooltip shrink cursor-default" data-tip="Deactivated">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="w-4 h-4 md:w-5 md:h-5 text-red-600">
                            <path fill="currentColor" d="M12 4c-4.411 0-8 3.589-8 8s3.589 8 8 8s8-3.589 8-8s-3.589-8-8-8zm-5 8c0-.832.224-1.604.584-2.295l6.711 6.711A4.943 4.943 0 0 1 12 17c-2.757 0-5-2.243-5-5zm9.416 2.295L9.705 7.584A4.943 4.943 0 0 1 12 7c2.757 0 5 2.243 5 5c0 .832-.224 1.604-.584 2.295z"/>
                        </svg>
                    </div>
                </div>
            </button>
        </slide-up-down>
    </div>
</template>

<script>
import {useDashboardCampaignStore} from "@/stores/dashboard/campaign";
import {mapState} from "pinia";

export default {
    name: "CampaignsSidebar",

    props: {
        domains: {
            required: true,
            type: Object,
        },
    },

    data() {
        return {
            sliderStates: {},
            route: this.route,
        };
    },

    computed: {
        ...mapState(useDashboardCampaignStore, ['selected', 'sidebarItems']),
    },

    mounted() {
        Object.keys(this.sidebarItems)
            .forEach(domain => this.sliderStates[domain] = false);

        if (!useDashboardCampaignStore().hasData) {
            const firstDomain = Object.keys(this.sidebarItems)[0];
            const keywords = this.sidebarItems[firstDomain];

            this.fetchDomainKeyword(keywords[0]);
        }

        setTimeout(() => {
            Object.keys(this.sidebarItems)
                .forEach(domain => this.sliderStates[domain] = true);
        }, 100);
    },

    created() {
        useDashboardCampaignStore().setSidebarItems(this.domains);
    },

    methods: {
        fetchDomainKeyword(keyword) {
            this.selected.domain = keyword.domain;
            this.selected.keyword = keyword.keyword;
            this.selected.keywordId = keyword.id;

            useDashboardCampaignStore().fetch(keyword.id);
        },
    },
}
</script>
