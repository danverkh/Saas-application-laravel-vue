<template>
    <div class="flex items-center justify-between p-7 pb-6">
        <div class="relative md:max-w-sm">
            <svg class="w-6 h-6 text-zinc-400 absolute left-4 top-3" width="32" height="32" viewBox="0 0 24 24">
                <path fill="currentColor" d="m21 19l-5.154-5.154a7 7 0 1 0-2 2L19 21l2-2zM5 10c0-2.757 2.243-5 5-5s5 2.243 5 5s-2.243 5-5 5s-5-2.243-5-5z"/>
            </svg>

            <Input placeholder="Filter keywords" v-model="keyword" @change="debouncedFilter" class="text-zinc-900 text-base pl-14"/>
        </div>

        <div class="flex-1 px-4">
            <div v-if="filters.mustContainUrl" class="inline-flex items-center m-0 px-3 py-2 bg-zinc-100 hover:bg-zinc-300/40 rounded-full flex-grow-0 text-sm font-medium border border-zinc-200">
                <button class="btn btn-circle btn-ghost btn-xs mr-1 -ml-1 text-md" @click="toggleMustContainUrlFilter">
                    <svg class="w-4 h-4" width="32" height="32" viewBox="0 0 36 36"><path fill="currentColor" d="m19.41 18l8.29-8.29a1 1 0 0 0-1.41-1.41L18 16.59l-8.29-8.3a1 1 0 0 0-1.42 1.42l8.3 8.29l-8.3 8.29A1 1 0 1 0 9.7 27.7l8.3-8.29l8.29 8.29a1 1 0 0 0 1.41-1.41Z" class="clr-i-outline clr-i-outline-path-1"/><path fill="none" d="M0 0h36v36H0z"/></svg>
                </button>
                contains URL
            </div>

            <div v-if="filters.searchVolume.value" class="inline-flex items-center m-0 px-3 py-2 bg-zinc-100 hover:bg-zinc-300/40 rounded-full flex-grow-0 text-sm font-medium border border-zinc-200">
                <button class="btn btn-circle btn-ghost btn-xs mr-1 -ml-1 text-md" @click="">
                    <svg class="w-4 h-4" width="32" height="32" viewBox="0 0 36 36"><path fill="currentColor" d="m19.41 18l8.29-8.29a1 1 0 0 0-1.41-1.41L18 16.59l-8.29-8.3a1 1 0 0 0-1.42 1.42l8.3 8.29l-8.3 8.29A1 1 0 1 0 9.7 27.7l8.3-8.29l8.29 8.29a1 1 0 0 0 1.41-1.41Z" class="clr-i-outline clr-i-outline-path-1"/><path fill="none" d="M0 0h36v36H0z"/></svg>
                </button>
                Search volume
                {{ filters.searchVolume.comparisonOperator === 'greater' ? '>' : '<' }}
                {{ filters.searchVolume.value }}
            </div>
        </div>

        <div ref="filtersDropdown" class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost text-sm">
                <svg class="w-4 h-4 stroke-current mr-2" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M4.25 5.61C6.27 8.2 10 13 10 13v6c0 .55.45 1 1 1h2c.55 0 1-.45 1-1v-6s3.72-4.8 5.74-7.39A.998.998 0 0 0 18.95 4H5.04c-.83 0-1.3.95-.79 1.61z"/></svg>
                Filters
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 space-y-1">
                <li>
                    <a href="#" @click.prevent="toggleMustContainUrlFilter" :class="{'bg-zinc-100 text-primary': filters.mustContainUrl}">Must contain URL</a>
                </li>
                <li>
                    <a href="#" @click.prevent="setFilterModal('searchVolume')" :class="{'bg-zinc-100 text-primary': filters.searchVolume.value}">Search volume</a>
                </li>
                <li>
                    <a href="#" @click.prevent="setFilterModal('cpc')" :class="{'bg-zinc-100 text-primary': filters.cpc.value}">CPC</a>
                </li>
                <li>
                    <a href="#" @click.prevent="setFilterModal('rank')" :class="{'bg-zinc-100 text-primary': filters.rank.value}">Rank</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import Input from "@/components/Input.vue";
import debounce from "lodash/debounce";
import {useRankingItemsStore} from "@/stores/rankingItems";
import {mapState} from "pinia";
import Modal from "@/services/Modal";
import EventBus from "@/services/EventBus";

export default {
    name: "RankingTableFilters",

    components: {Input},

    data() {
        return {
            keyword: '',
        };
    },

    computed: {
        ...mapState(useRankingItemsStore, ['filters']),
    },

    methods: {
        debouncedFilter: debounce(function () {
            this.setFilter('keyword', this.keyword.toLowerCase().trim());
        }, 300),

        toggleMustContainUrlFilter() {
            useRankingItemsStore().filters.mustContainUrl = !useRankingItemsStore().filters.mustContainUrl;
        },

        setFilter(key, value) {
            useRankingItemsStore().filters[key].value = value;
        },

        setFilterModal(filter) {
            EventBus.emit('setFilterModal.filter', filter);
            Modal.open('set-filter-modal');
        },
    },
}
</script>
