import {defineStore} from 'pinia'
import {useCart} from './cart';
import maxBy from 'lodash/maxBy';
import RelevanceData from "@/services/RelevanceData";

export const useRankingItemsStore = defineStore('rankingItems', {
    persist: {
        paths: ['userAddedItems'],
    },

    state: () => {
        return {
            items: [],
            userAddedItems: {}, // users own keywords
            filters: {
                keyword: {
                    value: '',
                },
                mustContainUrl: {
                    value: false,
                },
                searchVolume: {
                    value: null,
                    operator: null,
                },
                cpc: {
                    value: null,
                    operator: null,
                },
                rank: {
                    value: null,
                    operator: null,
                },
            },
            max: {
                searchVolume: 0,
                cpc: 0,
            },
        };
    },

    getters: {
        selectedItems: (state) => state.items.filter(item => item.selected),

        filteredItems: (state) => {
            let items = state.items.filter(item => {
                return state.filters.keyword.value.length
                    ? item.keyword.includes(state.filters.keyword.value)
                    : true;
            });

            if (state.filters.mustContainUrl.value) {
                items = items.filter(item => item.url !== null && item.url?.length > 0);
            }

            if (state.filters.searchVolume.value !== null) {
                items = items.filter(item => {
                    if (state.filters.searchVolume.operator === 'greater' && item.search_volume > state.filters.searchVolume.value) {
                        return true;
                    } else if (state.filters.searchVolume.operator === 'smaller' && item.search_volume < state.filters.searchVolume.value) {
                        return true;
                    }
                });
            }

            if (state.filters.cpc.value !== null) {
                items = items.filter(item => {
                    if (state.filters.cpc.operator === 'greater' && item.cpc > state.filters.cpc.value) {
                        return true;
                    } else if (state.filters.cpc.operator === 'smaller' && item.cpc < state.filters.cpc.value) {
                        return true;
                    }
                });
            }

            if (state.filters.rank.value !== null) {
                items = items.filter(item => {
                    if (state.filters.rank.operator === 'greater' && item.current_rank > state.filters.rank.value) {
                        return true;
                    } else if (state.filters.rank.operator === 'smaller' && item.current_rank < state.filters.rank.value) {
                        return true;
                    }
                });
            }

            state.max.searchVolume = maxBy(items, 'search_volume')?.search_volume ?? 0;
            state.max.cpc = maxBy(items, 'cpc')?.cpc ?? 0;

            return items;
        },

        findByKeyword: (state) => {
            return (keyword) => state.items.find(i => i.keyword === keyword);
        },
    },

    actions: {
        setItems(items) {
            const key = useCart().domain +'_'+ useCart().market;

            if (Object.keys(this.userAddedItems).length && this.userAddedItems[key]) {
                items = this.userAddedItems[key].concat(items);
            }

            const savedSelections = useCart().selectedItems;

            this.items = items.map(item => {
                return {
                    ...item,
                    selected: savedSelections.find(i => i.keyword === item.keyword) !== undefined,
                    relevance: null,
                };
            });

            // call fetch relevance by chunks one after the other
            RelevanceData.fetchAll(this.items, 5);
        },

        add(item) {
            item.selected = true;
            this.saveSelectedItems();
        },

        remove(item) {
            item.selected = false;
            this.saveSelectedItems();
        },

        saveSelectedItems() {
            useCart().setSelectedItems(this.items.filter(item => item.selected));
        },

        addUserAddedItem(item) {
            const key = useCart().domain +'_'+ useCart().market;

            if (this.userAddedItems[key]) {
                this.userAddedItems[key].push(item);
            } else {
                this.userAddedItems[key] = [item];
            }
        },

        contains(keyword) {
            const keywordLowerCase = keyword.toLowerCase();

            return this.items.find(i => i.keyword === keywordLowerCase);
        },

        addFilter(filter, value, operator) {
            this.filters[filter].value = value;
            this.filters[filter].operator = operator;
        },

        removeFilter(filter) {
            this.filters[filter].value = null;
            this.filters[filter].operator = null;
        },
    },
});
