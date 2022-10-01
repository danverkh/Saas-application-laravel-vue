<template>
    <Modal name="domain-switcher-modal" width="max-w-3xl" overflow="overflow-visible" @opened="focusSearch">
        <div class="flex sm:flex-nowrap items-end gap-5 md:gap-6 p-4 pt-2">
            <MainSearch ref="search"></MainSearch>
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
            this.$refs.search.clear();
            this.$refs.search.focusSearch();
        },
    },
}
</script>
