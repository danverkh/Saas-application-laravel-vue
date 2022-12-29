<template>
    <div class="flex items-center items-start justify-between flex-col md:flex-row gap-y-5 p-7 pb-6">
        <div class="relative w-full md:max-w-xs lg:max-w-xs self-start">
            <svg class="w-6 h-6 text-zinc-400 absolute left-3 top-3" width="32" height="32" viewBox="0 0 24 24">
                <path fill="currentColor" d="m21 19l-5.154-5.154a7 7 0 1 0-2 2L19 21l2-2zM5 10c0-2.757 2.243-5 5-5s5 2.243 5 5s-2.243 5-5 5s-5-2.243-5-5z"/>
            </svg>

            <Input placeholder="Filter keywords" v-model="keyword" @change="debouncedFilter" class="text-zinc-900 text-base pl-11"/>
        </div>

        <div class="flex-1 md:px-4 flex flex-wrap gap-3">
            <AppliedFilter v-if="filters.mustContainUrl.value"
                           @removed="toggleMustContainUrl">
                contains URL
            </AppliedFilter>

            <AppliedFilter v-if="filters.searchVolume.value"
                           :value="filters.searchVolume.value"
                           :operator="filters.searchVolume.operator"
                           @click="setFilterModal('searchVolume')"
                           @removed="removeFilter('searchVolume')">
                Search volume
            </AppliedFilter>

            <AppliedFilter v-if="filters.cpc.value"
                           :value="filters.cpc.value"
                           :operator="filters.cpc.operator"
                           @click="setFilterModal('cpc')"
                           @removed="removeFilter('cpc')">
                CPC
            </AppliedFilter>

            <AppliedFilter v-if="filters.rank.value"
                           :value="filters.rank.value"
                           :operator="filters.rank.operator"
                           @click="setFilterModal('rank')"
                           @removed="removeFilter('rank')">
                Rank
            </AppliedFilter>
        </div>

        <div ref="filtersDropdown" class="dropdown dropdown-end self-end md:self-start">
            <label tabindex="0" class="btn btn-ghost text-sm">
                <svg class="w-4 h-4 stroke-current mr-2" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M4.25 5.61C6.27 8.2 10 13 10 13v6c0 .55.45 1 1 1h2c.55 0 1-.45 1-1v-6s3.72-4.8 5.74-7.39A.998.998 0 0 0 18.95 4H5.04c-.83 0-1.3.95-.79 1.61z"/></svg>
                Filters
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 space-y-1">
                <li>
                    <button @click.prevent="toggleMustContainUrl" :class="{'text-zinc-500/60': filters.mustContainUrl.value}">Must contain URL</button>
                </li>
                <li>
                    <button @click.prevent="setFilterModal('searchVolume')" :class="{'text-zinc-500/60': filters.searchVolume.value}">Search volume</button>
                </li>
                <li>
                    <button @click.prevent="setFilterModal('cpc')" :class="{'text-zinc-500/60': filters.cpc.value}">CPC</button>
                </li>
                <li>
                    <button @click.prevent="setFilterModal('rank')" :class="{'text-zinc-500/60': filters.rank.value}">Rank</button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import AppliedFilter from "@/pages/booking/ranking/Filters/AppliedFilter.vue";
import EventBus from "@/services/EventBus";
import Input from "@/components/Input.vue";
import Modal from "@/services/Modal";
import debounce from "lodash/debounce";
import {mapState} from "pinia";
import {useRankingItemsStore} from "@/stores/rankingItems";
import Url from "@/services/Url";

export default {
    name: "RankingTableFilters",

    components: {AppliedFilter, Input},

    data() {
        return {
            keyword: '',
        };
    },

    computed: {
        ...mapState(useRankingItemsStore, ['filters']),
    },

    watch: {
        filters: {
            handler(filters) {
                Url.setQueryParams(filters);
            },
            deep: true,
        },
    },

    mounted() {
        this.setFiltersFromUrl();
    },

    methods: {
        debouncedFilter: debounce(function () {
            useRankingItemsStore().filters['keyword'].value = this.keyword.toLowerCase().trim();
        }, 300),

        toggleMustContainUrl() {
            useRankingItemsStore().filters.mustContainUrl.value = !useRankingItemsStore().filters.mustContainUrl.value;
        },

        setFilterModal(filter) {
            EventBus.emit('setFilterModal.filter', filter);
            Modal.open('set-filter-modal');
        },

        removeFilter(filter) {
            useRankingItemsStore().removeFilter(filter);
        },

        setFiltersFromUrl() {
            const params = Url.allQueryParams();

            Object.keys(params).forEach(key => {
                this.filters[key] = params[key];
            });

            this.keyword = this.filters['keyword'].value;
        },
    },
}
</script>
