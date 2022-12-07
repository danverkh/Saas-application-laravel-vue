import {defineStore} from 'pinia'
import {useCart} from './cart';
import maxBy from 'lodash/maxBy';
import chunk from 'lodash/chunk';

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

            state.max.searchVolume = maxBy(items, 'search_volume').search_volume;
            state.max.cpc = maxBy(items, 'cpc').cpc;

            return items;
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
            chunk(this.items, 50).reduce(async (referencePoint, chunk) => {
                await referencePoint;
                await this.fetchRelevance(chunk);
            }, Promise.resolve());
        },

        async fetchRelevance(chunk) {
            return new Promise((resolve, reject) => {
                const data = {
                    items: chunk.map(row => {
                        return {
                            keyword: row.keyword,
                            rank: row.current_rank,
                            url: row.url,
                        };
                    }),
                    market: useCart().market,
                    domain: useCart().domain,
                };

               axios.post(route('api.keywords.relevance'), data)
                    .then(({data}) => {
                        chunk.forEach(row => row.relevance = data[row.keyword]);
                        resolve();
                    })
                    .catch(error => {
                        console.error('Failed to fetch relevance for keywords', error);
                        reject();
                    });
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
