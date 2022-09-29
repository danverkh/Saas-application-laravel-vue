import {useAuth} from '@/stores/auth';

export default {
    install(app) {
        const store = useAuth();
        const auth = document.getElementById('app').getAttribute('data-auth');

        if (auth) {
            try {
                store.user = JSON.parse(auth);
                store.check = true;
            } catch (e) {
                console.warn('Failed to populate $auth', e);
            }
        }
        app.config.globalProperties.$auth = store;
    },
};
