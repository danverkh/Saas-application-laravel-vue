<x-main-layout>

    <div class="mt-14">
        <div class="mx-auto text-center text-5xl tracking-wider text-zinc-900 font-normal flex justify-center">
            <h1 class="text-5xl font-bold text-zinc-900 mb-12">
                About <span class="text-primary">us</span>
            </h1>
        </div>
    </div>

    <!-- Offer -->
    <section>
        <div class="py-10 mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="relative flex items-center justify-end bg-zinc-100 rounded-r-3xl border-b-4 border-zinc-300/60">
                    <div class="p-8 sm:p-16 lg:p-24 text-right">
                        <div class="text-5xl mb-3">We want to offer a</div>

                        <div class="text-zinc-900">
                            <div class="font-bold text-6xl mb-2">
                                <span class="text-primary">performance</span>-only
                            </div>

                            <div class="font-bold text-7xl mb-5">
                                <span class="text-primary">SEO</span> service
                            </div>
                        </div>

                        <div class="text-xl tracking-wider max-w-lg">
                            especially catering to smaller businesses who compete against much larger firms
                        </div>
                    </div>
                </div>

                <div class="flex flex-row flex-nowrap">
                    <div class="flex-grow content">
                        <img class="max-h-[27em] ml-14" src="/img/team-working.svg"/>
                    </div>

                    <div class="flex-grow rounded-l-3xl bg-primary h-full border-b-4 border-red-700"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company -->
    <x-container class="font-normal text-base leading-[1.7rem] px-32 mb-6">
        <x-subtitle>Company</x-subtitle>

        <p class="mb-5">AutoRanker was founded in 2019 and serves a bit over 200 mostly small and mid-sized businesses. Prior to AutoRanker, a member of our team spent six years
            implementing autocomplete-optimization projects for a small client base and this way, gained the necessary experience for AutoRanker.</p>
        <p class="mb-5">As our client, you benefit from almost 8 years of experience and hundreds of previously completed projects. We are your specialist when it comes to
            positioning your brand in the autocomplete function of search engines and we would love to work with you.</p>
        <p class="mb-5">We always conduct our work in a transparent and organic manner. We think long-term, plan painstakingly and support our clients in the creation, controlling
            and adjustments of their campaigns. Our own keyword database, a reporting portal and e-mail reports compliment our offerings.</p>
        <p class="mb-5">When implementing a campaign we hold ourselves to high standards - both the commercial success of our clients and the value-add to end users who interact
            with the suggests we manage. We only accept projects we personally believe in and which offer a sustained positive experience to end users.</p>
    </x-container>

    <!-- Team -->
    <div class="bg-primary">
        <x-container>
            <div class="mx-auto mb-10 lg:max-w-xl sm:text-center">
                <x-subtitle>Our team</x-subtitle>
            </div>

            <div class="grid gap-10 mx-auto lg:grid-cols-2 lg:max-w-screen-lg mb-6">
                <x-team-member image="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=3&amp;h=375&amp;w=630"
                               name="Oliver Aguilerra"
                               position="Product Manager"
                               description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, beatae."
                               twitter="#"
                               facebook="#"></x-team-member>

                <x-team-member image="https://images.pexels.com/photos/2381069/pexels-photo-2381069.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=375&amp;w=630"
                               name="Marta Clermont"
                               position="Design Team Lead"
                               description="Amet I love liquorice jujubes pudding croissant I love pudding."
                               twitter="#"
                               facebook="#"></x-team-member>

                <x-team-member image="https://images.pexels.com/photos/3747435/pexels-photo-3747435.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=375&amp;w=630"
                               name="Alice Melbourne"
                               position="Human Resources"
                               description="Lorizzle ipsum bling bling sit amizzle, consectetuer adipiscing elit."
                               twitter="#"
                               facebook="#"></x-team-member>

                <x-team-member image="https://images.pexels.com/photos/3931603/pexels-photo-3931603.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=750&amp;w=1260"
                               name="John Doe"
                               position="Lead Developer"
                               description="Bacon ipsum dolor sit amet salami jowl corned beef, andouille flank.."
                               twitter="#"
                               facebook="#"></x-team-member>
            </div>
        </x-container>
    </div>

    <!-- Testimonials -->
    @push('style')
    <link crossorigin="anonymous" href="https://unpkg.com/swiper/swiper-bundle.min.css" rel="stylesheet"/>
    @endpush

    <section class="bg-zinc-100">
        <div class="py-16 mx-auto lg:pr-0 lg:mr-0 sm:py-24">
            <div class="items-end justify-between max-w-7xl sm:flex mx-auto mb-14">
                <x-subtitle class="mb-0" :line="false">Reviews from our customers</x-subtitle>

                <div class="flex mt-8 lg:mt-0">
                    <button class="p-3 bg-primary text-white rounded-full focus:outline-none transition-all hover:scale-105 prev-button mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transform -rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <button class="p-3 bg-primary text-white rounded-full focus:outline-none transition-all hover:scale-105 next-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-8 -mx-6 lg:col-span-2 lg:mx-0">
                <div class="swiper-container overflow-hidden">
                    <div class="swiper-wrapper pb-6">
                        @foreach(\App\Repository\TestimonialsRepository::all() as $testimonial)
                        <div class="swiper-slide shadow-lg rounded-xl overflow-hidden max-w-lg">
                            <blockquote class="flex flex-col justify-between h-full p-12 bg-white">
                                <div>
                                    <div class="flex space-x-0.5 text-white">
                                      <span class="text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.326 18.266l-4.326-2.314-4.326 2.313.863-4.829-3.537-3.399 4.86-.671 2.14-4.415 2.14 4.415 4.86.671-3.537 3.4.863 4.829z"/>
                                        </svg>
                                      </span>
                                      <span class="text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.326 18.266l-4.326-2.314-4.326 2.313.863-4.829-3.537-3.399 4.86-.671 2.14-4.415 2.14 4.415 4.86.671-3.537 3.4.863 4.829z"/>
                                        </svg>
                                      </span>
                                      <span class="text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.326 18.266l-4.326-2.314-4.326 2.313.863-4.829-3.537-3.399 4.86-.671 2.14-4.415 2.14 4.415 4.86.671-3.537 3.4.863 4.829z"/>
                                        </svg>
                                      </span>
                                      <span class="text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.326 18.266l-4.326-2.314-4.326 2.313.863-4.829-3.537-3.399 4.86-.671 2.14-4.415 2.14 4.415 4.86.671-3.537 3.4.863 4.829z"/>
                                        </svg>
                                      </span>
                                      <span class="text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                          <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.326 18.266l-4.326-2.314-4.326 2.313.863-4.829-3.537-3.399 4.86-.671 2.14-4.415 2.14 4.415 4.86.671-3.537 3.4.863 4.829z"/>
                                        </svg>
                                      </span>
                                    </div>

                                    <div class="mt-4">
                                        <h5 class="text-2xl font-bold text-primary sm:text-3xl">{{ $testimonial['title'] }}</h5>

                                        <p class="mt-3 text-md text-zinc-600">
                                            {{ $testimonial['content'] }}
                                        </p>
                                    </div>
                                </div>

                                <footer class="mt-8 text-zinc-800">- {{ $testimonial['client'] }}</footer>
                            </blockquote>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')
    <script crossorigin="anonymous" defer src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.swiper-container', {
                loop: true,
                slidesPerView: 1.5,
                spaceBetween: 32,
                autoplay: {
                    delay: 8000,
                },
                navigation: {
                    nextEl: '.next-button',
                    prevEl: '.prev-button',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2.5,
                        centeredSlides: true,
                    },
                    1024: {
                        slidesPerView: 3.5,
                        centeredSlides: false,
                    },
                },
            })
        })
    </script>
    @endpush

</x-main-layout>
