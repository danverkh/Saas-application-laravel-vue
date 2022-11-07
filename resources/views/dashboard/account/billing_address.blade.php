<div class="text-md md:text-3xl font-medium text-zinc-700 -mt-2">Billing Address</div>

<div class="divider divider-vertical my-3"></div>

<billing-address :data='@json($billingAddress)'
                 :country-options='@json($countryOptions)'></billing-address>
