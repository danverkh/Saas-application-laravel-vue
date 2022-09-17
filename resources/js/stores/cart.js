import {defineStore} from 'pinia';
import axios from 'axios';
import FullScreenSpinner from '@/services/FullScreenSpinner';
import {scrollToError} from '@/services/ValidationService';

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

    actions: {
        setSelectedItems(items) {
            this.selectedItems = items;
        },

        validate() {
            this.validationErrors = [];

            FullScreenSpinner.open();

            return axios.post(route('api.checkout.order.validate'), this.$state)
                .then(() => {
                    window.location.href = route('checkout.payment')
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        scrollToError();
                    } else {
                        console.error('Failed to validate order', error);
                        alert('Whoops, something went wrong... Please try again later.');
                    }
                    FullScreenSpinner.close();
                });
        },

        createOrder() {
            this.validationErrors = [];

            FullScreenSpinner.open();

            return axios.post(route('api.checkout.order'), this.$state)
                .then(() => {
                    window.localStorage.removeItem('cart');
                    window.location.href = route('checkout.thank_you');
                })
                .catch(error => {
                    if (error.response.status === 422) {
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
