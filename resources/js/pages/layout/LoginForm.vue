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

        <button class="btn btn-xs rounded-md !text-2xs font-normal normal-case px-3 tracking-widest disabled:bg-zinc-500" @click="submit" title="Login" :disabled="requestPending">
            <template v-if="requestPending">
                <Spinner :size="10" :border-width="2" color="#fff" class="mx-4"></Spinner>
            </template>
            <template v-else>Login</template>
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
                        window.location.href = route('dashboard.campaigns');
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
                        GlobalNotification.error({title: 'Whoops, something went wrong', message: 'Please try again later.'});
                    }
                })
                .finally(() => {
                    this.requestPending = false;
                });
        },
    },
}
</script>
