class Url {
    constructor() {
        this.parameters = new URLSearchParams(window.location.search);
    }

    getParam(key, defaultValue = null) {
        return this.parameters.get(key) || defaultValue;
    }
}

export default new Url;
