<template>
    <div>
        <slide-up-down v-model="checkoutInit" :duration="slideDuration" timing-function="ease-out">
            <customer-details class="mb-6"></customer-details>
        </slide-up-down>

        <checkout-button @clicked="proceed">
            <div v-if="!checkoutInit">Confirm keywords <br class="hidden xl:block"> and proceed</div>
            <div v-else class="text-xl tracking-widest text-center pl-5">Submit</div>
        </checkout-button>
    </div>
</template>

<script>
import CustomerDetails from './Checkout/CustomerDetailsCard.vue';
import CheckoutButton from './Checkout/CheckoutButton.vue';

export default {
    name: 'Checkout',

    components: {CheckoutButton, CustomerDetails},

    data() {
        return {
            checkoutInit: false,
            slideDuration: 300,
        };
    },

    methods: {
        proceed() {
            this.checkoutInit = true;

            setTimeout(() => document.getElementById('name').focus(), this.slideDuration);
        },
    },
}
</script>
