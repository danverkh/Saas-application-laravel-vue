import {defineStore} from 'pinia';
import axios from 'axios';
import FullScreenSpinner from '@/services/FullScreenSpinner';
import {scrollToError} from '@/services/ValidationService';
import GlobalNotification from "@/services/GlobalNotification";

export const useCart = defineStore('cart', {
    persist: true,

    state: () => {
        return {
            email: '',
            market: null,
            domain: null,
            selectedItems: [],
            validationErrors: [],
        };
    },

    actions: {
        clearSelection() {
            this.setSelectedItems([]);
        },

        setSelectedItems(items) {
            this.selectedItems = items;
        },

        createOrder() {
            this.validationErrors = [];

            FullScreenSpinner.open();

            return new Promise(resolve => {
                axios.post(route('checkout.order'), this.$state)
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
                            GlobalNotification.error('Whoops, something went wrong... Please try again later.');
                        }
                        FullScreenSpinner.close();
                    });
            });
        },
    },
});
