<x-main-layout>
    <div class="relative">
        <div class="relative z-10 max-w-screen-xl px-6 py-14 mx-auto flex flex-col items-center">
            <h1 class="text-5xl font-bold text-zinc-900 mb-12">
                How it <span class="text-primary">works</span>
            </h1>

            <div class="shadow-strong rounded-xl overflow-hidden bg-gray-200 border-2 border-zinc-300 w-full max-w-3xl aspect-video mb-12">
                <video-player image="/img/homepage_video.png" video="/video/homepage.mp4"/>
            </div>
        </div>

        <div id="hero-bg" class="absolute top-0 left-0 right-0 bottom-0 z-0 overflow-hidden"></div>
    </div>

    <div class="bg-primary py-4">
        <x-container class="text-white text-lg leading-relaxed max-w-5xl">
            <div class="flex flex-col lg:flex-row flex-nowrap gap-1 lg:gap-6">
                <div class="basis-1/3 text-4xl lg:text-5xl font-semibold text-center lg:text-right lg:!leading-[4rem]">
                    Consectetur adipisicing expedita
                </div>
                <div class="divider divider-vertical lg:divider-horizontal"></div>
                <div class="basis-2/3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus aliquam asperiores aut autem beatae blanditiis deserunt dignissimos dolor doloremque
                    doloribus itaque laboriosam laborum quis ratione reprehenderit, sit temporibus. Ab consectetur delectus et eum iusto magnam molestiae natus neque, numquam omnis
                    porro possimus quas quos rerum totam vel vitae. Commodi eaque et facilis illum magni molestias quasi repellat velit? Dolores ducimus ea expedita harum libero
                    nostrum numquam pariatur sit temporibus veritatis. Consequatur cupiditate eveniet nesciunt reiciendis sapiente similique totam? Itaque.
                </div>
            </div>
        </x-container>
    </div>

    <div class="bg-white py-8">
        <x-container class="text-zinc-800 text-lg leading-relaxed max-w-5xl">
            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur corporis cupiditate eligendi esse ex ipsa modi, odit quos unde voluptas. Eaque explicabo sed
                similique tenetur veniam. Doloremque expedita iure maxime nam quis tempora ullam! At deserunt ea error ipsam iste neque quis quod voluptates. Laudantium libero nemo
                officia quas recusandae. Ad asperiores commodi deserunt error explicabo quisquam, soluta tenetur veritatis! Aliquid architecto assumenda consequatur deserunt in
                numquam pariatur veritatis voluptatum.</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A alias autem commodi dolorem, eius excepturi laudantium magni mollitia nobis quibusdam quis, tenetur
                voluptatibus. Esse labore mollitia, quaerat quam quasi unde.</p>
        </x-container>
    </div>

    <div class="bg-primary py-8">
        <x-container>
            <div class="flex flex-nowrap flex-col lg:flex-row gap-8 xl:gap-24 px-8 md:px-20 xl:px-0">
                <div class="basis-1/2 p-4">
                    <h4 class="text-white text-3xl font-semibold mb-7 text-center">Keyword 1</h4>
                    <canvas id="chart-1" class="w-full h-12"></canvas>
                </div>
                <div class="basis-1/2 p-4">
                    <h4 class="text-white text-3xl font-semibold mb-7 text-center">Keyword 2</h4>
                    <canvas id="chart-2" class="w-full h-12"></canvas>
                </div>
            </div>
        </x-container>
    </div>

    <div>
        <x-search-keyword-or-domain></x-search-keyword-or-domain>
    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    @endpush

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const chart1 = {
                    labels: ['22.07', '', '', '', '23.07', '', '', '', '24.07', '', '', '', '25.07'],
                    data: [2.23, 2.215, 2.22, 2.25, 2.245, 2.27, 2.28, 2.29, 2.3, 2.29, 2.325, 2.325, 2.32],
                };
                const chart2 = {
                    labels: ['22.07', '', '', '', '23.07', '', '', '', '24.07', '', '', '', '25.07'],
                    data: [2.18, 2.21, 2.22, 2.25, 2.24, 2.27, 2.28, 2.29, 2.3, 2.29, 2.325, 2.31, 2.35],
                };

                initChart('chart-1', chart1.labels, chart1.data);
                initChart('chart-2', chart2.labels, chart2.data);

                function initChart(id, labels, data) {
                    let ctx = document.getElementById(id).getContext('2d');

                    new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: '',
                                    backgroundColor: "rgba(255, 255, 255, 0.1)",
                                    borderColor: "rgba(255, 255, 255, 1)",
                                    pointBackgroundColor: "rgba(255, 255, 255, 1)",
                                    data: data,
                                },
                            ],
                        },
                        layout: {},
                        options: {
                            legend: {
                                display: false,
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        fontColor: "rgba(255, 255, 255, 1)",
                                    },
                                    gridLines: {
                                        display: false,
                                    },
                                }],
                                xAxes: [{
                                    ticks: {
                                        fontColor: "rgba(255, 255, 255, 1)",
                                    },
                                    gridLines: {
                                        color: "rgba(255, 255, 255, .2)",
                                        borderDash: [5, 5],
                                        zeroLineColor: "rgba(255, 255, 255, .2)",
                                        zeroLineBorderDash: [5, 5]
                                    },
                                }]
                            }
                        }
                    });
                }
            });
        </script>
    @endpush

    @push('script')
        <script src="/js/three.min.js"></script>
        <script src="/js/vanta.net.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                VANTA.NET({
                    el: "#hero-bg",
                    mouseControls: false,
                    touchControls: false,
                    gyroControls: false,
                    minHeight: 300.00,
                    minWidth: 800.00,
                    scale: 1.00,
                    scaleMobile: 1.00,
                    color: 0xFF96A6,
                    backgroundColor: 0xffffff,
                    points: 5.00,
                    maxDistance: 75.00,
                    showDots: false,
                    spacing: 60.00,
                })
            });
        </script>
    @endpush
</x-main-layout>
