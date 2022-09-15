import {defineStore} from 'pinia';
import axios from 'axios';
import FullScreenSpinner from "../services/FullScreenSpinner";
import {scrollToError} from "../services/ValidationService";

export const useCart = defineStore('cart', {
    persist: true,

    state: () => {
        return {
            customer_name: '',
            customer_email: '',
            market: null,
            domain: null,
            selectedItems: [],
            validationErrors: [],
        };
    },

    getters: {
        valid() {
            return this.customer_name.length > 0 && this.customer_email.length > 0
                && this.market !== null && this.domain !== null
                && this.selectedItems.length > 0;
        },
    },

    actions: {
        setSelectedItems(items) {
            this.selectedItems = items;
        },

        createOrder() {
            this.validationErrors = [];

            FullScreenSpinner.open();

            axios.post(route('api.checkout.order'), this.$state)
                .then(() => {
                    window.localStorage.removeItem('cart');
                    window.location.href = route('checkout.thank_you');
                })
                .catch(error => {
                    if (error.request.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        scrollToError();
                    } else {
                        console.error('Failed to create order', error);
                        alert('Whoops, something went wrong... Please try again later.');
                    }
                })
                .finally(() => FullScreenSpinner.close());
        },
    },
});
