<template>
    <div v-for="(keywords, domain) in domains" :key="`sidebar-${domain}`" class="dropdown w-full py-2 space-y-1">
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
                v-for="domainKeyword in sortKeywords(keywords)"
                :key="`sidebar-${domain}-${domainKeyword.keyword}`"
                :class="[
                    'btn btn-ghost btn-block text-sm text-left normal-case font-medium break-words h-auto py-2 justify-start',
                    (domainKeyword.keyword === selected.keyword) ? 'text-primary bg-zinc-100 font-semibold' : '',
                ]"
                @click="fetchDomainKeyword(domainKeyword)"
            >
                {{ domainKeyword.keyword }}
            </button>
        </slide-up-down>
    </div>
</template>

<script>
import {sort} from 'fast-sort';
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
        ...mapState(useDashboardCampaignStore, ['selected'])
    },

    mounted() {
        if (!useDashboardCampaignStore().hasData) {
            const firstDomain = Object.keys(this.domains)[0];
            const keywords = this.sortKeywords(this.domains[firstDomain]);

            this.fetchDomainKeyword(keywords[0]);
        }
    },

    created() {
        Object.keys(this.domains)
            .forEach(domain => this.sliderStates[domain] = true);
    },

    methods: {
        sortKeywords(items) {
            return sort(items).asc('keyword');
        },

        fetchDomainKeyword(keyword) {
            useDashboardCampaignStore().selected.domain = keyword.domain;
            useDashboardCampaignStore().selected.keyword = keyword.keyword;

            useDashboardCampaignStore().fetch(keyword.id);
        },
    },
}
</script>
