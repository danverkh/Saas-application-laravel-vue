<template>
    <Modal name="set-filter-modal" classes="max-w-md px-6 sm:px-10 py-7 sm:py-9" @opened="reset">
        <div class="text-2xl text-center mb-6">Set filter for {{ filterLabel }}</div>

        <div class="flex flex-nowrap items-center">
            <div class="min-w-[120px] z-10">
                <Select v-model="comparisonOperator" :options="comparisonOperators" :placeholder="null" class="rounded-r-none"></Select>
            </div>

            <div class="px-3 py-2.5 text-lg bg-zinc-200 border border-zinc-300">
                than
            </div>

            <div class="w-full z-10">
                <Input v-model.number="value" type="number" @keyup.enter="submit" class="text-center text-zinc-900 text-base rounded-l-none"/>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button @click="submit" class="btn btn-success px-12" :class="{'pointer-events-none opacity-25': !valid}">
                Set
            </button>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/components/Modal.vue";
import EventBus from "@/services/EventBus";
import Select from "@/components/Select.vue";
import Input from "@/components/Input.vue";
import snakeCase from 'lodash/snakeCase';
import isNumber from 'lodash/isNumber';
import {useRankingItemsStore} from "@/stores/rankingItems";
import ModalService from "@/services/Modal";

export default {
    name: "SetFilterModal",

    components: {Select, Input, Modal},

    data() {
        return {
            filter: null,
            value: 0,
            comparisonOperator: 'greater',
            comparisonOperators: [
                {value: 'greater', label: 'Greater'},
                {value: 'smaller', label: 'Smaller'},
            ],
        };
    },

    computed: {
        filterLabel() {
            return snakeCase(this.filter).replaceAll('_', ' ');
        },

        valid() {
            return isNumber(this.value);
        },
    },

    mounted() {
        EventBus.on('setFilterModal.filter', value => this.filter = value);
    },

    unmounted() {
        EventBus.off('setFilterModal.filter');
    },

    methods: {
        reset() {
            this.comparisonOperator = 'greater';
        },

        submit() {
            if (this.valid) {
                useRankingItemsStore().filters[this.filter].value = this.value;
                useRankingItemsStore().filters[this.filter].comparisonOperator = this.comparisonOperator;

                ModalService.close('set-filter-modal');
            }
        },
    },
}
</script>
