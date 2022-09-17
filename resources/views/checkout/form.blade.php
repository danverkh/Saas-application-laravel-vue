<x-main-layout>
    <div class="mt-14 -mb-5">
        <x-page-title>
            Checkout
            <span class="text-gray-400 ml-2 mr-4">/</span>
            <span class="text-primary">Payment</span>
        </x-page-title>
    </div>

    <x-container>
        <div class="flex flex-col max-w-4xl mx-auto">
            <div class="flex flex-col space-y-7">
                <!-- Payment -->
                <x-card bodyClass="p-8" class="border-t-4 border-primary">
                    <div class="h-20">

                    </div>
                </x-card>
            </div>

            <submit-order-button></submit-order-button>

            <hr>

            <img src="/img/payment_trust.jpg" class="w-full max-w-xl mx-auto my-8"/>
        </div>
    </x-container>
</x-main-layout>
