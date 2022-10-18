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
        useGlobalNotifications().open({type: 'error', ...config});
    }

    close() {
        useGlobalNotifications().close();
    }
}

export default new GlobalNotifications;
