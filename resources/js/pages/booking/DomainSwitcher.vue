<template>
    <div class="text-lg inline-block">
        Domain: <span class="font-semibold">{{ query }}</span>
        <label for="domain-switcher-modal" class="cursor-pointer text-sm -mt-1 ml-2 text-primary hover:underline relative bottom-0.5">(change)</label>
    </div>

    <Modal name="domain-switcher-modal" width="max-w-3xl">
        <div class="flex sm:flex-nowrap items-end gap-5 md:gap-6">
            <MainSearch></MainSearch>
        </div>
    </Modal>
</template>

<script>
import Modal from '../../components/Modal.vue';
import MainSearch from '../../pages/homepage/MainSearch.vue';

export default {
    name: "DomainSwitcher",

    components: {Modal, MainSearch},

    props: {
        market: String,
        query: String,
    },
}
</script>
