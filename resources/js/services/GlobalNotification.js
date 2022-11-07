import {useGlobalNotifications} from "@/stores/globalNotifications";

class GlobalNotifications {
    info(config) {
        useGlobalNotifications().open({type: 'info', ...config});
    }

    success(config) {
        useGlobalNotifications().open({type: 'success', ...config});
    }

    warning(config) {
        useGlobalNotifications().open({type: 'warning', ...config});
    }

    error(config) {
        useGlobalNotifications().open({type: 'error', timeout: 5000, ...config});
    }

    close() {
        useGlobalNotifications().close();
    }

    handle(config) {
        if (config.error) {
            const payload = {message: 'Please try again'};

            switch (config.error) {
                case 'unauthorized':
                    payload.title = 'You are not authorized to view the page';
                    payload.message = 'Make sure you are logged in';
                    break;
                default:
                    payload.title = 'Whoops, something went wrong';
            }

            this.error(payload);
        }
    }
}

export default new GlobalNotifications;
