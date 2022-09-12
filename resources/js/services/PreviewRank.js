import axios from 'axios';

class PreviewRank {
    constructor() {
        this.controller = null;
    }

    fetch(market, keywords) {
        // abort request if previous is not finished
        if (this.controller !== null) {
            this.abortFetch();
        }

        this.controller = new AbortController();

        const params = {market, keywords};

        return axios.get(route('api.preview_rank'), {signal: this.controller.signal, params})
            .finally(() => this.controller = null);
    }

    abortFetch() {
        this.controller.abort();
    }
}

export default new PreviewRank();