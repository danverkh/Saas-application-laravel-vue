<div class="text-md md:text-2xl font-medium text-zinc-700 mb-2">Billing Address</div>

<div class="divider divider-vertical my-0"></div>

<billing-address :data='@json($billingAddress)'
                 :country-options='@json($countryOptions)'></billing-address>
