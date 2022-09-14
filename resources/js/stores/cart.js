import {defineStore} from 'pinia'

export const useCart = defineStore('cart', {
    persist: true,

    state: () => {
        return {
            market: null,
            domain: null,
            selectedItems: [],
        };
    },

    actions: {
        setSelectedItems(items) {
            this.selectedItems = items;
        },
    },
});
