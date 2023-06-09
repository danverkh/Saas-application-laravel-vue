import cloneDeep from "lodash/cloneDeep";
import queryParser from "nested-query-parser";

class Url {
    constructor() {
        this.parameters = queryParser.decode(window.location.search);
        this.keepQueryParams = ['assistant'];
    }

    hasQueryParam() {
        return this.parameters.auto !== undefined;
    }

    getQueryParam(key, defaultValue = null) {
        return this.parameters[key] || defaultValue;
    }

    setQueryParams(params) {
        let newParams = cloneDeep(params);

        this.keepQueryParams.forEach(param => {
            let value = this.getQueryParam(param);
            if (value) {
                newParams[param] = value;
            }
        });

        Object.keys(newParams).forEach(key => {
            if (!newParams[key].value && !this.keepQueryParams.includes(key)) {
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
