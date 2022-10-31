@section('title', 'Data privacy')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <div class="mt-14">
        <x-page-title>
            Data Privacy <span class="text-primary">Statement</span>
        </x-page-title>
    </div>

    <x-container>
        <img src="/img/illustrations/privacy.svg" class="w-[500px] h-auto mx-auto -mt-12 mb-10"/>

        <div class="text-lg max-w-2xl mx-auto space-y-3 mb-10">
            <h3 class="text-3xl font-semibold pt-4">Data Processing on this Website</h3>

            <p>We collect and save automatically information in our Server Logs that are transferred by your browser to us.</p>
            <p>Those are:</p>
            <ul class="red-dots">
                <li>Browser type / version</li>
                <li>Operating system in use</li>
                <li>Referer URL (website visited before)</li>
                <li>Client's hostname (IP address)</li>
                <li>Time of server request</li>
            </ul>
            <p>These information is not assignable for us to specific persons. A combination of those data with other data sources is not done.</p>

            <h3 class="text-3xl mt-20 font-semibold pt-4">Analytics</h3>

            <p>Google Analytics is a web analytics service offered by Google that tracks and reports website traffic. Google uses the data collected to track and monitor the use of our Service. This data is shared with other Google services. Google may use the collected data to contextualise and personalise the ads of its own advertising network.</p>
            <p>For more information on the privacy practices of Google, please visit the Google Privacy & Terms web page: <x-link href="https://policies.google.com/privacy?hl=en" active target="_blank" rel="nofollow">https://policies.google.com/privacy</x-link></p>

            <h3 class="text-3xl mt-20 font-semibold pt-4">More Information</h3>
            <p>Your trust is important for us. Thus, we always want to answer to you when it comes to the processing of your personal data.</p>
            <p>If you have any questions that are not answered in this data privacy statement or you want to have more detailed information about one provision:</p>
            <p><x-link href="{{ route('imprint') }}" active>Please contact us at any time.</x-link></p>
        </div>
    </x-container>
</x-main-layout>
