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
            },
        };
    },

    getters: {
        selectedItems: (state) => state.items.filter(item => item.selected),

        filteredItems: (state) => {
            return state.items.filter(item => {
                return (state.filters.keyword.value.length ? item.keyword.includes(state.filters.keyword.value) : true);
            });
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
    },
});
