<template>
    <transition name="fade">
        <div v-if="opened" class="fixed top-3 left-1/2 -translate-x-1/2 z-[1000] alert shadow-lg max-w-xl gap-0" :class="[!type ? 'bg-white' : `alert-${type}`]">
            <div class="-mb-2 md:mb-0">
                <div class="mx-3">
                    <svg v-if="!type" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <svg v-if="type === 'info'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <svg v-if="type === 'success'" xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <svg v-if="type === 'warning'" xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <svg v-if="type === 'error'" xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>

                <div class="flex flex-col gap-1">
                    <h3 v-if="title" class="font-bold">{{ title }}</h3>
                    <div v-if="message" class="text-xs" v-html="message"></div>
                </div>
            </div>
            <div class="flex-none">
                <div @click="close" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-50 hover:text-zinc-600 hover:bg-zinc-400/25">✕</div>
            </div>
        </div>
    </transition>
</template>

<script>
import {mapState} from 'pinia';
import {useGlobalNotifications} from "@/stores/globalNotifications";
import GlobalNotification from "@/services/GlobalNotification";

export default {
    name: "GlobalNotifications",

    computed: {
        ...mapState(useGlobalNotifications, ['opened', 'title', 'message', 'type']),
    },

    methods: {
        close() {
            GlobalNotification.close();
        },
    },
}
</script>

<style scoped>
.fade-enter-active {
    animation: fade-in ease-out .3s;
}
.fade-leave-active {
    animation: fade-in ease-in .2s reverse;
}
@keyframes fade-in {
    0% {
        opacity: 0;
        transform: translateY(-5px) translateX(-50%);
    }
    100% {
        opacity: 1;
        transform: translateY(0px) translateX(-50%);
    }
}
</style>
