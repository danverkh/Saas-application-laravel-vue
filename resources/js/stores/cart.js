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

            return new Promise(resolve => {
                axios.post(route('api.checkout.order.validate'), this.$state)
                    .then(response => resolve(response))
                    .catch(error => {
                        FullScreenSpinner.close();

                        if (error.response.status === 422) {
                            this.validationErrors = error.response.data.errors;
                            scrollToError();
                        } else {
                            console.error('Failed to validate order', error);
                            alert('Whoops, something went wrong... Please try again later.');
                        }
                    });
            });
        },

        createOrder() {
            this.validationErrors = [];

            FullScreenSpinner.open();

            return new Promise(resolve => {
                axios.post(route('api.checkout.order'), this.$state)
                    .then(response => {
                        window.localStorage.removeItem('cart');
                        resolve(response);
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
            });
        },
    },
});
