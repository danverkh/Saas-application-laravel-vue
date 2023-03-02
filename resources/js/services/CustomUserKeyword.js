import {useCart} from "@/stores/cart";
import axios from "axios";
import RelevanceData from "@/services/RelevanceData";

class CustomUserKeyword {
    validateKeyword(keyword) {
        const params = {
            market: useCart().market,
            domain: useCart().domain,
            keyword: keyword.keyword,
        };

        keyword.requestPending = true;

        axios.get(route('api.keyword.validate'), {params})
            .then(({data}) => {
                keyword.status = data.result;

                if (data.data) {
                    keyword.cpc = data.data?.cpc;
                    keyword.maximum_cost = data.data?.maximum_cost;
                    keyword.projected_clicks = data.data?.projected_clicks;
                    keyword.projected_traffic = data.data?.projected_traffic;
                    keyword.search_volume = data.data?.search_volume;
                }

                keyword.requestPending = false;

                if (keyword.status === 'possible') {
                    RelevanceData.fetch([keyword]);
                }
            })
            .catch(error => {
                console.error('Failed to validate keyword', error);

                // retry
                if (keyword.retry < 2) {
                    keyword.retry++;
                    this.validateKeyword(keyword);
                } else {
                    keyword.status = 'failed';
                    keyword.requestPending = false;
                }
            });
    }
}

export default new CustomUserKeyword;
