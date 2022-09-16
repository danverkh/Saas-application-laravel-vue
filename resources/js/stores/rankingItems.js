import {defineStore} from 'pinia'
import {useCart} from './cart';

export const useRankingItemsStore = defineStore('rankingItems', {
    state: () => {
        return {
            items: [],
        };
    },

    getters: {
        selectedItems: (state) => state.items.filter(item => item.selected),
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
    },
});
