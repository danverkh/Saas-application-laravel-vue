import cloneDeep from "lodash/cloneDeep";
import queryParser from "nested-query-parser";

class Url {
    constructor() {
        this.parameters = queryParser.decode(window.location.search);
    }

    getQueryParam(key, defaultValue = null) {
        return this.parameters[key] || defaultValue;
    }

    setQueryParams(params) {
        let newParams = cloneDeep(params);

        Object.keys(newParams).forEach(key => {
            if (!newParams[key].value) {
                delete newParams[key];
            }
        });
        window.history.replaceState(null, null, queryParser.encode(newParams) || window.location.pathname);
    }

    allQueryParams() {
        return this.parameters;
    }

}

export default new Url;
