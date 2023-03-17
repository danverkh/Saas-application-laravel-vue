<template>
    <div v-for="(keywords, domain) in domains" :key="`sidebar-${domain}`" class="dropdown w-full py-2 space-y-1">
        <label
            @click="sliderStates[domain] = !sliderStates[domain]"
            :class="[
                'btn btn-ghost btn-block text-base normal-case break-all',
                Object.keys(keywords).find(k => keywords[k].keyword === keyword.keyword) ? 'bg-primary hover:bg-primary text-white hover:text-zinc-200' : 'bg-zinc-100'
            ]"
        >
            {{ domain }}
        </label>
        <slide-up-down v-model="sliderStates[domain]" :duration="300" timing-function="ease-out">
            <a
                v-for="domainKeyword in sortKeywords(keywords)"
                :key="`sidebar-${domain}-${domainKeyword.keyword}`"
                :href="campaignKeywordRoute(domainKeyword.id)"
                :class="[
                    'btn btn-ghost btn-block text-sm normal-case font-medium break-all py-2 justify-start',
                    (domainKeyword.id === keyword.id) ? 'text-primary bg-zinc-100 font-semibold' : '',
                ]"
            >
                {{ domainKeyword.keyword }}
            </a>
        </slide-up-down>
    </div>
</template>

<script>
import {sort} from 'fast-sort';

export default {
    name: "CampaignsSidebar",

    props: {
        domains: {
            required: true,
            type: Object,
        },
        keyword: {
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

    created() {
        Object.keys(this.domains)
            .forEach(domain => this.sliderStates[domain] = true);
    },

    methods: {
        sortKeywords(items) {
            return sort(items).asc('keyword');
        },

        campaignKeywordRoute(id) {
            return route('dashboard.campaigns.keyword', id);
        },
    },
}
</script>
