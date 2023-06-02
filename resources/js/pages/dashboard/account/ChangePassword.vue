<template>
    <div>
        <div class="flex flex-col gap-y-4">
            <div class="flex flex-col gap-y-2">
                <label for="current_password" class="whitespace-nowrap font-medium required">Current password</label>
                <Input v-model="form.current_password" id="current_password" type="password" :error="validationErrors?.current_password" @change="validationErrors.current_password = null" class="text-zinc-900 text-base"/>
            </div>

            <div class="flex flex-col gap-y-2">
                <label for="new_password" class="whitespace-nowrap font-medium required">New password</label>
                <Input v-model="form.new_password" id="new_password" type="password" :error="validationErrors?.new_password" @change="validationErrors.new_password = null" class="text-zinc-900 text-base"/>
            </div>

            <div class="flex flex-col gap-y-2">
                <label for="new_password_confirmation" class="whitespace-nowrap font-medium required">Confirm new password</label>
                <Input v-model="form.new_password_confirmation" id="new_password_confirmation" type="password" :error="validationErrors?.new_password_confirmation" @change="validationErrors.new_password_confirmation = null" class="text-zinc-900 text-base"/>
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

    data() {
        return {
            form: {
                current_password: '',
                new_password: '',
                new_password_confirmation: '',
            },
            requestPending: false,
            validationErrors: {},
        };
    },

    methods: {
        submit() {
            this.requestPending = true;

            axios.put(route('dashboard.account.password_change.save'), this.form)
                .then(() => {
                    GlobalNotification.success({title: 'Success', message: 'Password was saved successfully'});
                    this.form.current_password = '';
                    this.form.new_password = '';
                    this.form.new_password_confirmation = '';
                })
                .catch(error => {
                    console.error('Failed to submit form', error);
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
