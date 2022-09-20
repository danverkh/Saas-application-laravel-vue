<template>
    <div class="flex flex-col gap-y-4">
        <div class="flex flex-col gap-y-2">
            <label for="subject" class="whitespace-nowrap font-medium">Please choose a subject</label>
            <Select v-model="form.subject" :options="subjectOptions" id="subject"></Select>
        </div>

        <div class="flex flex-col gap-y-2">
            <label for="potential_campaign" class="whitespace-nowrap font-medium">Discuss a potential new campaign</label>
            <Select v-model="form.potential_campaign" :options="potentialCampaignOptions" id="potential_campaign"></Select>
        </div>

        <div class="flex flex-row flex-nowrap mt-6 gap-x-6">
            <div class="basis-1/2 flex flex-col gap-y-2">
                <label for="name" class="whitespace-nowrap font-medium">Your name</label>
                <Input @keyup.enter="submit" v-model="form.name" id="name" :error="validationErrors?.name" class="text-zinc-900 text-base"/>
            </div>

            <div class="basis-1/2 flex flex-col gap-y-2">
                <label for="email" class="whitespace-nowrap font-medium">Your email</label>
                <Input @keyup.enter="submit" v-model="form.email" type="email" id="email" :error="validationErrors?.email" class="text-zinc-900 text-base"/>
            </div>
        </div>

        <div class="flex flex-col gap-y-2">
            <label for="message" class="whitespace-nowrap font-medium">Your message</label>
            <Textarea v-model="form.message" id="message" :rows="4" :error="validationErrors?.message"></Textarea>
        </div>

        <SubmitButton @click="submit" :disabled="requestPending" class="mt-4 mb-6">
            <Spinner v-if="requestPending" color="#ffffff" :size="25" :border-width="4" class="ml-2"></Spinner>

            <span class="flex flex-nowrap" v-else>
                Submit
                <svg width="32" height="32" viewBox="0 0 32 32" class="w-6 h-6 ml-2">
                    <path fill="currentColor" d="M27.71 4.29a1 1 0 0 0-1.05-.23l-22 8a1 1 0 0 0 0 1.87l8.59 3.43L19.59 11L21 12.41l-6.37 6.37l3.44 8.59A1 1 0 0 0 19 28a1 1 0 0 0 .92-.66l8-22a1 1 0 0 0-.21-1.05Z"/>
                </svg>
            </span>
        </SubmitButton>
    </div>
</template>

<script>
import Input from '@/components/Input.vue';
import Textarea from '@/components/Textarea.vue';
import SubmitButton from "@/components/SubmitButton.vue";
import Select from "@/components/Select.vue";
import {scrollToError} from "@/services/ValidationService";
import Spinner from "@/components/Spinner.vue";

export default {
    name: "BookADemoForm",

    components: {Spinner, Select, SubmitButton, Input, Textarea},

    data() {
        return {
            form: {
                subject: null,
                potential_campaign: null,
                name: '',
                email: '',
                message: '',
            },

            subjectOptions: [
                {value: 'email-request', label: 'Send an E-Mail request'},
                {value: 'book-a-call', label: 'Book a call with us'},
            ],
            potentialCampaignOptions: [
                {value: 'existing-campaign', label: 'Discuss an existing campaign'},
                {value: 'reselling-or-agency-support', label: 'Reselling / Agency Support'},
                {value: 'other', label: 'Other'},
            ],
            requestPending: false,
            validationErrors: {},
        };
    },

    methods: {
        submit() {
            this.requestPending = true;

            axios.post(route('api.book_a_demo.submit'), this.form)
                .then(() => {
                    alert(123);
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        scrollToError();
                    } else {
                        console.error('Failed to submit form', error);
                        alert('Whoops, something went wrong... Please try again later.');
                    }
                })
                .finally(() => this.requestPending = false);
        },
    },
}
</script>
