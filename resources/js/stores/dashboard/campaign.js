import {defineStore} from 'pinia'
import axios from "axios";

export const useDashboardCampaignStore = defineStore('dashboard.campaign', {
    state: () => {
        return {
            loading: false,
            selected: {
                domain: null,
                keyword: null,
            },
            data: {},
            _controller: null,
        };
    },

    getters: {
        hasData: (state) => state.data.keyword !== undefined,
    },

    actions: {
        fetch(keywordId) {
            // abort request if previous is not finished
            if (this._controller !== null) {
                this.abortFetch();
            }
            const timeoutHandle = setTimeout(() => this.loading = true, 100);

            this._controller = new AbortController();

            return axios.get(route('dashboard.api.campaign.keyword', keywordId), {signal: this._controller.signal})
                .then(({data}) => {
                    this.data = data.data
                })
                .catch(error => {
                    this.data = {};
                    console.error('Failed to fetch keyword', error);
                })
                .finally(() => {
                    clearInterval(timeoutHandle);
                    this.loading = false;
                    this._controller = null;
                });
        },

        abortFetch() {
            if (this._controller) {
                this._controller.abort();
            }
        },
    },
});
