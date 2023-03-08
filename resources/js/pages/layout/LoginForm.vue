<template>
    <form class="flex max-w-[310px]" :class="[type === 'modal' ? 'gap-5' : 'gap-3']">
        <div class="relative">
            <Input
                @keyup.enter="submit"
                v-model="form.email"
                type="email"
                placeholder="Email"
                autocomplete="email"
                :error="validationErrors?.email"
                @change="validationErrors.email = null"
                error-classes="text-xs"
                :error-text="false"
                class="text-zinc-900 px-2 rounded"
                :class="[type === 'modal' ? 'btn-md' : 'btn-xs']"
            />
            <AtSymbolIcon v-if="type === 'modal'" class="absolute w-5 h-5 top-3.5 right-4"/>
        </div>

        <div class="relative">
            <Input
                @keyup.enter="submit"
                v-model="form.password"
                type="password"
                placeholder="Password"
                autocomplete="current-password"
                :error="validationErrors?.password"
                @change="validationErrors.password = null"
                error-classes="text-xs"
                :error-text="false"
                class="text-zinc-900 px-2 rounded"
                :class="[type === 'modal' ? 'btn-md' : 'btn-xs']"
            />
            <LockClosedIcon v-if="type === 'modal'" class="absolute w-5 h-5 top-3.5 right-4"/>
        </div>

        <ErrorMessage v-if="type === 'modal' && firstValidationError" :no-icon="true" class="text-sm">
            {{ firstValidationError }}
        </ErrorMessage>

        <button
            class="btn rounded-md font-normal normal-case px-3 tracking-widest disabled:bg-zinc-500"
            :class="[type === 'modal' ? 'btn-md !text-base' : 'btn-xs !text-2xs']"
            @click="submit"
            :disabled="requestPending"
        >
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
import ErrorMessage from "@/components/ErrorMessage.vue";
import {AtSymbolIcon, LockClosedIcon} from '@heroicons/vue/24/outline';

export default {
    name: "LoginForm",

    components: {ErrorMessage, Spinner, Input, AtSymbolIcon, LockClosedIcon},

    props: {
        type: {
            default: 'header',
            type: String,
        },
    },

    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            requestPending: false,
            validationErrors: {},
            firstValidationError: null,
        };
    },

    methods: {
        submit() {
            if (this.requestPending) {
                return;
            }

            this.requestPending = true;
            this.firstValidationError = null;
            this.validationErrors = {};

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
                        this.firstValidationError = this.validationErrors[firstKey][0];

                        if (this.type !== 'modal') {
                            GlobalNotification.warning({
                                title: 'Failed to login',
                                message: this.firstValidationError,
                            });
                        }
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
