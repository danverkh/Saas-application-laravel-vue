import {defineStore} from 'pinia';

export const useGlobalNotifications = defineStore('globalNotifications', {
    persist: true,

    state: () => {
        return {
            title: null,
            message: null,
            opened: false,
            type: '',
            timeoutId: null,
        };
    },

    actions: {
        close() {
            this.opened = false;
            clearTimeout(this.timeoutId);
        },

        open(config) {
            this.title = config.title || '';
            this.message = config.message || '';
            this.type = config.type || '';
            this.opened = true;

            this.timeoutId = setTimeout(() => this.opened = false, config.timeout || 3000);
        },

        info(config) {
            this.open({
                type: 'info',
                ...config,
            });
        },

        success(config) {
            this.open({
                type: 'success',
                ...config,
            });
        },

        warning(config) {
            this.open({
                type: 'warning',
                ...config,
            });
        },

        error(config) {
            this.open({
                type: 'error',
                ...config,
            });
        },
    },
});
