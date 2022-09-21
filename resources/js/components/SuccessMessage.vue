<template>
    <div class="alert rounded-xl bg-green-500/25 border border-green-500/50">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 text-green-600 h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>
                <slot></slot>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: "SuccessMessage",
}
</script>
