<template>
    <form class="flex gap-3 max-w-[300px]">
        <Input @keyup.enter="submit"
               v-model="form.email"
               type="email"
               placeholder="Email"
               autocomplete="email"
               :error="validationErrors?.email"
               @change="validationErrors.email = null"
               error-classes="text-xs"
               :error-text="false"
               class="text-zinc-900 input-xs px-2 rounded"/>

        <Input @keyup.enter="submit"
               v-model="form.password"
               type="password"
               placeholder="Password"
               autocomplete="current-password"
               :error="validationErrors?.password"
               @change="validationErrors.password = null"
               error-classes="text-xs"
               :error-text="false"
               class="text-zinc-900 input-xs px-2 rounded"/>

        <button class="btn btn-xs rounded-md !text-2xs font-normal normal-case disabled:bg-zinc-500" @click="submit" title="Login" :disabled="requestPending">
            <template v-if="requestPending">
                <Spinner :size="10" :border-width="2" color="#fff" class="mx-4"></Spinner>
            </template>
            <template v-else>
                <svg class="w-3 h-3 -ml-0.5 mr-1" viewBox="0 0 256 256">
                    <path fill="currentColor" d="m144.5 136.5l-42 42A12 12 0 0 1 94 182a12.2 12.2 0 0 1-8.5-3.5a12 12 0 0 1 0-17L107 140H24a12 12 0 0 1 0-24h83L85.5 94.5a12 12 0 0 1 17-17l42 42a12 12 0 0 1 0 17ZM192 28h-56a12 12 0 0 0 0 24h52v152h-52a12 12 0 0 0 0 24h56a20.1 20.1 0 0 0 20-20V48a20.1 20.1 0 0 0-20-20Z"/>
                </svg>
                Login
            </template>
        </button>
    </form>
</template>

<script>
import Input from '@/components/Input.vue';
import Spinner from "@/components/Spinner.vue";
import GlobalNotification from '@/services/GlobalNotification';

export default {
    name: "LoginForm",

    components: {Spinner, Input},

    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            requestPending: false,
            validationErrors: {},
        };
    },

    methods: {
        submit() {
            if (this.requestPending) {
                return;
            }

            this.requestPending = true;

            axios.post(route('login'), this.form)
                .then(({data}) => {
                    if (data.status === 'success') {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;

                        let firstKey = Object.keys(this.validationErrors)[0];

                        GlobalNotification.warning({
                            title: 'Failed to login',
                            message: this.validationErrors[firstKey][0],
                        });
                    } else {
                        console.error('Failed to login', error);
                        alert('Whoops, something went wrong... Please try again later.');
                    }
                })
                .finally(() => {
                    this.requestPending = false;
                });
        },
    },
}
</script>