import {useCart} from "@/stores/cart";
import chunk from "lodash/chunk";
import {useRankingItemsStore} from "@/stores/rankingItems";

class RelevanceData {
    constructor() {
        this.activeRequestCount = 0;
        this.maxActiveRequests  = 10;
        this.chunks             = [];
        this.currentChunkIndex  = 0;
    }

    fetchAll(items, chunkSize) {
        this.chunks = chunk(items, chunkSize);

        for (let i = 0; i < this.maxActiveRequests; i++) {
            if (this.chunks[i]) {
                this.fetch(this.chunks[i]);
            }
        }
    }

    fetch(chunk) {
        this.activeRequestCount++;

        const data = {
            items: chunk
                .filter(row => row.url)
                .map(row => {
                    return {
                        keyword: row.keyword,
                        rank: row.current_rank || 0,
                        url: row.url,
                    };
                }),
            market: useCart().market,
            domain: useCart().domain,
        };

        if (data.items.length === 0) {
            return;
        }

        axios.post(route('api.keywords.relevance'), data)
            .then(({data}) => {
                if (this.maxActiveRequests > this.activeRequestCount && (this.chunks.length - 1) > this.currentChunkIndex) {
                    this.fetch(this.chunks[++this.currentChunkIndex]);
                }
                chunk.forEach(row => row.relevance = data[row.keyword] || row.relevance);
            })
            .catch(error => {
                console.error('Failed to fetch relevance for keywords', error);
            })
            .finally(() => {
                this.activeRequestCount--;

                useRankingItemsStore().sortItems();
            });
    }
}

export default new RelevanceData;
