import {defineStore} from 'pinia'
import axios from "axios";
import {sort} from "fast-sort";
import dayjs from "dayjs";

export const useDashboardCampaignStore = defineStore('dashboard.campaign', {
    state: () => {
        return {
            sidebarItems: {},
            loading: false,
            selected: {
                domain: null,
                keyword: null,
                keywordId: null,
            },
            data: {
                search_volume: 0,
                creation_date: '',
                rankings: [],
            },
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
                    this.data = data.data;
                })
                .catch(error => {
                    this.data = {};
                    console.error('Failed to fetch keyword', error);
                })
                .finally(() => {
                    clearInterval(timeoutHandle);
                    this.loading     = false;
                    this._controller = null;
                });
        },

        abortFetch() {
            if (this._controller) {
                this._controller.abort();
            }
        },

        setSidebarItems(items) {
            this.sidebarItems = items;

            Object.keys(this.sidebarItems)
                .forEach(domain => {
                    this.sidebarItems[domain] = sort(this.sidebarItems[domain]).asc('keyword');
                });
        },

        markKeywordAsCancelled(keywordId) {
            Object.keys(this.sidebarItems)
                .forEach(domain => {
                    const index = this.sidebarItems[domain].findIndex(i => i.id === keywordId);

                    if (index !== -1) {
                        this.sidebarItems[domain][index].termination_date = dayjs().format('YYYY-MM-DD H:mm:ss');
                    }
                });

            this.data.termination_date = dayjs().format('YYYY-MM-DD H:mm:ss');
        },

        markKeywordAsReactivated(keywordId) {
            Object.keys(this.sidebarItems)
                .forEach(domain => {
                    const index = this.sidebarItems[domain].findIndex(i => i.id === keywordId);

                    if (index !== -1) {
                        this.sidebarItems[domain][index].termination_date = null;
                    }
                });

            this.data.termination_date = null;
        },
    },
});
