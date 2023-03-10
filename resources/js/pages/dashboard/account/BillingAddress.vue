<template>
    <div>
        <div class="flex flex-col gap-y-4">
            <div class="flex flex-col gap-y-2">
                <label for="company_name" class="whitespace-nowrap font-medium">Company name</label>
                <Input v-model="form.company_name" id="company_name" :error="validationErrors?.company_name" @change="validationErrors.company_name = null" class="text-zinc-900 text-base"/>
            </div>

            <div class="flex flex-col gap-y-2">
                <label for="street" class="whitespace-nowrap font-medium required">Street</label>
                <Input v-model="form.street" id="street" :error="validationErrors?.street" @change="validationErrors.street = null" class="text-zinc-900 text-base"/>
            </div>

            <div class="flex flex-row flex-nowrap gap-x-6">
                <div class="w-1/2 flex flex-col gap-y-2">
                    <label for="postal_code" class="whitespace-nowrap font-medium required">Postal code</label>
                    <Input v-model="form.postal_code" id="postal_code" :error="validationErrors?.postal_code" @change="validationErrors.postal_code = null" class="text-zinc-900 text-base"/>
                </div>
                <div class="w-1/2 flex flex-col gap-y-2">
                    <label for="city" class="whitespace-nowrap font-medium required">City</label>
                    <Input v-model="form.city" id="city" :error="validationErrors?.city" @change="validationErrors.city = null" class="text-zinc-900 text-base"/>
                </div>
            </div>

            <div class="flex flex-col gap-y-2">
                <label for="country" class="whitespace-nowrap font-medium required">Country</label>
                <Select v-model="form.country_id"
                        :options="countryOptions"
                        id="country"
                        :error="validationErrors?.country_id"
                        @change="validationErrors.country_id = null"></Select>
            </div>

            <div class="flex flex-col gap-y-2">
                <label for="vat_number" class="whitespace-nowrap font-medium">VAT Number</label>
                <Input v-model="form.vat_number" id="vat_number" :error="validationErrors?.vat_number" @change="validationErrors.vat_number = null" class="text-zinc-900 text-base"/>
            </div>
        </div>

        <div class="mt-9">
            <SubmitButton @click="submit" :disabled="requestPending" color="secondary">
                <Spinner v-if="requestPending" color="#ffffff" :size="25" :border-width="4" class="ml-2"></Spinner>
                <span class="flex flex-nowrap" v-else>Save</span>
            </SubmitButton>
        </div>
    </div>
</template>

<script>
import {scrollToError} from "@/services/ValidationService";
import GlobalNotification from "@/services/GlobalNotification";
import SubmitButton from "@/components/SubmitButton.vue";
import Spinner from "@/components/Spinner.vue";

export default {
    name: "BillingAddress",

    components: {SubmitButton, Spinner},

    props: {
        data: Object,
        countryOptions: Array,
    },

    data() {
        return {
            form: {
                company_name: this.data?.company_name || '',
                street: this.data?.street || '',
                postal_code: this.data?.postal_code || '',
                city: this.data?.city || '',
                country_id: this.data?.country_id || null,
                vat_number: this.data?.vat_number || '',
            },
            requestPending: false,
            validationErrors: {},
        };
    },

    methods: {
        submit() {
            this.requestPending = true;

            axios.put(route('dashboard.account.billing_address.save'), this.form)
                .then(() => {
                    GlobalNotification.success({title: 'Success', message: 'Billing address was saved successfully'});
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        scrollToError();
                    } else {
                        console.error('Failed to submit form', error);
                        GlobalNotification.error({title: 'Whoops, something went wrong', message: 'Please try again later.'});
                    }
                })
                .finally(() => this.requestPending = false);
        },
    },
}
</script>
