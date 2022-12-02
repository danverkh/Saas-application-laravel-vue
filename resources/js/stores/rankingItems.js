import {defineStore} from 'pinia'
import {useCart} from './cart';

export const useRankingItemsStore = defineStore('rankingItems', {
    state: () => {
        return {
            items: [],
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

            return items;
        },
    },

    actions: {
        setItems(items) {
            const savedSelections = useCart().selectedItems;

            this.items = items.map(item => {
                return {
                    ...item,
                    selected: savedSelections.find(i => i.keyword === item.keyword) !== undefined,
                };
            });
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
