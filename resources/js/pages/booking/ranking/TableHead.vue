<template>
    <th>
        <div @click="sort" :class="[{'cursor-pointer': sortable}, 'flex items-center gap-1 text-zinc-700 hover:text-zinc-500 transition-all']">
            <div class="text-xs select-none">
                <slot/>
            </div>
            <ChevronIcon v-if="sortable" :sort="sortState" classes="w-2.5 h-4"/>
        </div>
    </th>
</template>

<script>
import {useRankingItemsStore} from "@/stores/rankingItems";
import ChevronIcon from "@/icons/ChevronIcon.vue";

export default {
    name: "TableHead",

    components: {ChevronIcon},

    props: {
        field: {
            required: true,
            type: String,
        },
        sortable: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        sortState() {
            return useRankingItemsStore().sort[this.field] || null;
        },
    },

    methods: {
        sort() {
            if (!this.sortable) {
                return;
            }
            useRankingItemsStore().sortBy(this.field);
        },
    },
}
</script>
