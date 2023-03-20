<template>
    <div class="btm-nav drop-shadow-[0_12px_12px_rgba(0,0,0,0.5)] backdrop-blur-[10px] bg-white-500/90 z-50">
        <button @click="scrollTo('keywords')" :class="{'text-primary active': current === 'keywords'}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" width="32" height="32" fill="none" viewBox="0 0 24 24">
                <path fill="currentColor" d="M3 4h4v4H3V4m6 1v2h12V5H9m-6 5h4v4H3v-4m6 1v2h12v-2H9m-6 5h4v4H3v-4m6 1v2h12v-2H9"/>
            </svg>
            <span class="btm-nav-label">Keywords</span>
        </button>
        <button @click="scrollTo('forecast')" :class="{'text-primary active': current === 'forecast'}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" width="32" height="32" viewBox="0 0 256 256" stroke="currentColor">
                <g fill="currentColor">
                    <path d="M224 56v152H32V48h184a8 8 0 0 1 8 8Z" opacity=".2"/>
                    <path d="M232 208a8 8 0 0 1-8 8H32a8 8 0 0 1-8-8V48a8 8 0 0 1 16 0v108.69l50.34-50.35a8 8 0 0 1 11.32 0L128 132.69L180.69 80H160a8 8 0 0 1 0-16h40a8 8 0 0 1 8 8v40a8 8 0 0 1-16 0V91.31l-58.34 58.35a8 8 0 0 1-11.32 0L96 123.31l-56 56V200h184a8 8 0 0 1 8 8Z"/>
                </g>
            </svg>
            <span class="btm-nav-label">Forecast</span>
        </button>
        <button @click="scrollTo('domain')" :class="{'text-primary active': current === 'domain'}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" width="32" height="32" viewBox="0 0 256 256" stroke="currentColor">
                <path fill="currentColor" d="M128 26a102 102 0 1 0 102 102A102.12 102.12 0 0 0 128 26Zm81.57 64h-40.18a139.15 139.15 0 0 0-23.45-50.2A90.32 90.32 0 0 1 209.57 90Zm8.43 38a89.7 89.7 0 0 1-3.83 26h-42.31a159 159 0 0 0 0-52h42.31a89.7 89.7 0 0 1 3.83 26Zm-90 90a1.75 1.75 0 0 1-1.32-.59C113.8 203.54 104.34 185.73 99 166h58c-5.34 19.73-14.8 37.54-27.68 51.41a1.75 1.75 0 0 1-1.32.59Zm-31.69-64a147.48 147.48 0 0 1 0-52h63.38a147.48 147.48 0 0 1 0 52ZM38 128a89.7 89.7 0 0 1 3.83-26h42.31a159 159 0 0 0 0 52H41.83A89.7 89.7 0 0 1 38 128Zm90-90a1.75 1.75 0 0 1 1.32.59C142.2 52.46 151.66 70.27 157 90H99c5.34-19.73 14.8-37.54 27.68-51.41A1.75 1.75 0 0 1 128 38Zm-17.94 1.8A139.15 139.15 0 0 0 86.61 90H46.43a90.32 90.32 0 0 1 63.63-50.2ZM46.43 166h40.18a139.15 139.15 0 0 0 23.45 50.2A90.32 90.32 0 0 1 46.43 166Zm99.51 50.2a139.15 139.15 0 0 0 23.45-50.2h40.18a90.32 90.32 0 0 1-63.63 50.2Z"/>
            </svg>
            <span class="btm-nav-label">Domain</span>
        </button>
    </div>
</template>

<script>
export default {
    name: "MobileBottomNavigation",

    data() {
        return {
            current: 'keywords',
        };
    },

    mounted() {
        window.scrollObserver('#rankings-table', {
            threshold: 0.01,
            onShow: () => this.current = 'keywords',
        });

        window.scrollObserver('#forecast', {
            threshold: 0.5,
            onShow: () => this.current = 'forecast',
        });

        window.scrollObserver('#domain-card', {
            threshold: 1,
            onShow: () => this.current = 'domain',
        });
    },

    methods: {
        scrollTo(target) {
            this.current = target;

            let id;

            if (target === 'keywords') {
                id = '#rankings-table';
            } else if (target === 'forecast') {
                id = '#forecast';
            } else if (target === 'domain') {
                id = '#domain-card';
            }

            const content = document.querySelector('.drawer-content');
            let pos = document.querySelector(id).getBoundingClientRect();

            content
                .scroll({
                    top: pos.top + content.scrollTop - 110,
                    behavior: 'smooth',
                });
        },
    },
}
</script>
