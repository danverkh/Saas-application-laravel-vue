@section('title', 'Book a demo')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <div class="mt-14 mb-6">
        <x-page-title>
            Book a <span class="text-primary">demo</span>
        </x-page-title>
    </div>

    <header class="-mt-5">
        <x-container>
            <div class="flex flex-col md:flex-row md:flex-nowrap justify-between mb-10 gap-x-6">
                <div class="basis-1/2 pt-5 mb-16">
                    <h3 class="text-zinc-700 text-center md:text-left font-semibold text-2xl md:text-4xl">Ad vix debet docendi</h3>

                    <p class="text-zinc-500 mt-5 text-lg text-center md:text-left">Ne dicta praesent ocurreret has, diam theophrastus at pro.</p>

                    <div class="mt-10 space-y-10 lg:max-w-[80%]">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 text-white bg-primary rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium leading-6">Per ei quaeque sensibus</h4>
                                <p class="text-sm text-zinc-400 mt-2">Ex usu illum iudico molestie. Pro ne agam facete mediocritatem, ridens labore facete mea ei.</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 text-white bg-primary rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium leading-6">Cu imperdiet posidonium sed</h4>
                                <p class="text-sm text-zinc-400 mt-2">Amet utinam aliquando ut mea, malis admodum ocurreret nec et, elit tibique cu nec.</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 text-white bg-primary rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium leading-6">Nulla omittam sadipscing mel ne</h4>
                                <p class="text-sm text-zinc-400 mt-2">At sed possim oporteat probatus, justo graece ne nec, minim commodo legimus ut vix.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="basis-1/2">
                    <x-card class="px-0 lg:px-8 border border-zinc-100">
                        <h2 class="text-zinc-700 text-2xl font-medium text-center mt-2">Book a demo with us</h2>

                        <div class="w-8 h-1 bg-primary my-2.5 mx-auto"></div>

                        <book-a-demo-form></book-a-demo-form>
                    </x-card>
                </div>
            </div>
        </x-container>
    </header>
</x-main-layout>
