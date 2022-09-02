<template>
    <div class="w-24 md:28">
        <Listbox v-model="selectedItem">
            <div class="relative mt-1">
                <ListboxLabel class="text-gray-500">Market</ListboxLabel>

                <ListboxButton class="relative w-full cursor-pointer rounded-lg bg-white mt-1 py-4 pl-5 pr-10 text-left ring-1 ring-gray-300 hover:ring-2 hover:ring-primary/50 sm:text-sm transition-all focus:ring-2 focus:ring-primary/50 focus:outline-none">
                    <span class="block truncate text-lg text-center font-semibold">{{ selectedItem.label }}</span>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                    <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
                </ListboxButton>

                <transition
                    leave-active-class="transition duration-100 ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <ListboxOptions class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-gray-400 ring-opacity-5 focus:outline-none sm:text-sm">
                        <ListboxOption
                            v-slot="{ active, selected }"
                            v-for="item in items"
                            :key="item.label"
                            :value="item"
                            as="template"
                        >
                            <li :class="[active ? 'bg-gray-100 text-primary' : 'text-gray-900', selected ? 'bg-primary-50/25' : '', 'relative cursor-pointer select-none py-2 pl-10 pr-4']">
                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate md:pl-1']">{{ item.label }}</span>
                                <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-2 md:pl-3 text-primary">
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                            </span>
                            </li>
                        </ListboxOption>
                    </ListboxOptions>
                </transition>
            </div>
        </Listbox>
    </div>
</template>

<script setup>
import {ref, watch} from 'vue'
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
    ListboxLabel,
} from '@headlessui/vue'
import {CheckIcon, ChevronUpDownIcon} from '@heroicons/vue/24/solid'

const items = [
    {value: 'at', label: 'AT'},
    {value: 'ch', label: 'CH'},
    {value: 'de', label: 'DE'},
    {value: 'uk', label: 'UK'},
    {value: 'fr', label: 'FR'},
    {value: 'it', label: 'IT'},
    {value: 'es', label: 'ES'},
]
const selectedItem = ref(items[0])

const emit = defineEmits(['changed']);

watch(selectedItem, (item) => {
    emit('changed', item.value);
});
</script>
