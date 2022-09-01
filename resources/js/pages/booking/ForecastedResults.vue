<template>
    <div>
        <div class="text-md">Target audience size</div>
        <div class="text-2xl font-semibold">17,000+</div>
    </div>

    <input type="range" min="1" max="100" value="35" class="range range-xs text-primary my-3"/>

    <div class="divider divider-vertical my-0"></div>

    <div class="tabs w-full flex-nowrap -mt-3 mb-3">
        <a class="tab tab-lg tab-active">1-day</a>
        <a class="tab tab-lg">7-day</a>
        <a class="tab tab-lg">30-day</a>
    </div>

    <div class="mb-4">
        <div class="text-md">1-day spend</div>
        <div class="text-2xl font-semibold">€36.00 - €840.00</div>
    </div>

    <div class="mb-4">
        <div class="text-md">1-day impressions</div>
        <div class="text-2xl font-semibold">14,000 - 5,700</div>
    </div>

    <div class="mb-4">
        <div class="text-md">CTR</div>
        <div class="text-2xl font-semibold">1.0% - 1.6%</div>
    </div>

    <div class="mb-4">
        <div class="text-md">
            30-day clicks
            <div class="badge bg-violet-600 border-none ml-2">Key Result</div>
        </div>
        <div class="text-2xl font-semibold">20 - 84</div>
    </div>
</template>

<script>
export default {
    name: "ForecastedResults"
}
</script>
