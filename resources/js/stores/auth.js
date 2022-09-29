import {defineStore} from 'pinia';

export const useAuth = defineStore('auth', {
    state: () => {
        return {
            check: false,
            user: {
                id: null,
                name: '',
                email: '',
            },
        };
    },
});
