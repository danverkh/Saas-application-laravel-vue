import { defineStore } from 'pinia'

export const usePreviewRankStore = defineStore('previewRank', {
    state: () => {
        return {
            data: null,
        };
    },

    getters: {
        data: (state) => state.data,
    },

    actions: {
        set(data) {
            this.data = data;
        },
    },
})
