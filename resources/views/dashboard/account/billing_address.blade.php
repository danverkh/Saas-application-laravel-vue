<div class="space-y-10 xl:w-2/3">
    <div class="card md:max-w-xl bg-base-100 shadow-lg rounded-xl border border-zinc-100">
        <div class="p-10">
            <div class="text-center md:text-left text-xl md:text-2xl font-medium text-zinc-700 -mt-2">Billing Address</div>

            <div class="divider divider-vertical my-3"></div>

            <billing-address
                :data='@json($billingAddress)'
                :country-options='@json($countryOptions)'
            ></billing-address>
        </div>
    </div>
</div>
