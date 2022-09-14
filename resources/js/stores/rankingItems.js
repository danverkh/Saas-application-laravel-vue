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

            this.update();
        },

        toggleAll(value) {
            this.items.forEach(item => item.selected = value);

            this.saveSelectedItems();
        },

        update() {
            document.getElementById('check-all-items').indeterminate = !this.items.every(items => items.selected) && this.items.some(items => items.selected);
            document.getElementById('check-all-items').checked = this.items.every(items => items.selected);

            this.saveSelectedItems();
        },

        saveSelectedItems() {
            useCart().setSelectedItems(this.items.filter(item => item.selected));
        },
    },
});
