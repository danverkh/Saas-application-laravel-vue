import { defineStore } from 'pinia'
import axios from "axios";

export const usePreviewRankStore = defineStore('previewRank', {
    state: () => {
        return {
            keyword: null,
            results: [],
            _controller: null,
        };
    },

    actions: {
        fetch(market, keyword, domain) {
            // abort request if previous is not finished
            if (this._controller !== null) {
                this.abortFetch();
            }
            this.results = [];
            this.keyword = keyword;

            this._controller = new AbortController();

            const params = {market, keyword, domain};

            return axios.get(route('api.preview_rank'), {signal: this._controller.signal, params})
                .then(({data}) => this.results = data.data)
                .finally(() => this._controller = null);
        },

        abortFetch() {
            if (this._controller) {
                this._controller.abort();
            }
        },
    },
})
