<template>
    <Modal name="domain-switcher-modal" width="max-w-3xl" overflow="overflow-visible" @opened="focusSearch">
        <div class="flex sm:flex-nowrap items-end gap-5 md:gap-6">
            <MainSearch></MainSearch>
        </div>
    </Modal>
</template>

<script>

import Modal from "./Modal.vue";
import MainSearch from "@/pages/homepage/MainSearch.vue";

export default {
    name: "DomainSwitcherModal",

    components: {Modal, MainSearch},

    methods: {
        focusSearch() {
            document.querySelector('input.main-search').focus();
        },
    },
}
</script>
