<x-main-layout>
    <x-container>
        <div class="flex flex-col space-y-7">
            <!-- Selected keywords -->
            <x-card title="Selected Keywords" titleSize="text-2xl" bodyClass="p-8" class="border-t-4 border-primary max-w-4xl mx-auto">
                <keywords-table></keywords-table>
            </x-card>

            <!-- Customer details -->
            <x-card title="Customer details" titleSize="text-2xl" bodyClass="p-8" class="border-t-4 border-primary max-w-4xl mx-auto">
                <customer-details></customer-details>
            </x-card>

            <!-- Payment -->
            <x-card title="Payment" titleSize="text-2xl" bodyClass="p-8" class="border-t-4 border-primary max-w-4xl mx-auto">
                <div class="h-20">

                </div>
                <img src="/img/payment_trust.jpg" class="max-w-xl mx-auto"/>
            </x-card>

            <a href="#" class="mx-auto flex flex-nowrap items-center min-w-[220px] mt-6 md:mt-0 pl-3 pr-5 py-8 lg:py-5 xl:py-6 text-lg md:text-base xl:text-lg font-semibold text-white tracking-wider uppercase
                select-none transition duration-500 ease-in-out transform bg-green-600 rounded-2xl shadow-lg shadow-zinc-300 border border-green-700/50 hover:shadow-green-500/50">

                <svg width="24" height="24" viewBox="0 0 576 512" class="w-5 h-5 ml-3">
                    <path fill="currentColor" d="M576 216v16c0 13.255-10.745 24-24 24h-8l-26.113 182.788C514.509 462.435 494.257 480 470.37 480H105.63c-23.887 0-44.139-17.565-47.518-41.212L32 256h-8c-13.255 0-24-10.745-24-24v-16c0-13.255 10.745-24 24-24h67.341l106.78-146.821c10.395-14.292 30.407-17.453 44.701-7.058c14.293 10.395 17.453 30.408 7.058 44.701L170.477 192h235.046L326.12 82.821c-10.395-14.292-7.234-34.306 7.059-44.701c14.291-10.395 34.306-7.235 44.701 7.058L484.659 192H552c13.255 0 24 10.745 24 24zM312 392V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24zm112 0V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24zm-224 0V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24z"/>
                </svg>

                <span class="divider divider-horizontal mx-2"></span>

                <div class="flex-1 text-center">Submit</div>
            </a>
        </div>
    </x-container>
</x-main-layout>
