<x-main-layout>
    <x-container class="text-center py-24">
        @if($success)
            <spinner :size="80" :border-width="8"></spinner>
            <div class="mt-2 text-xl">Please wait</div>
        @else
            <svg class="w-36 h-36 text-red-600 inline-block" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 4a8 8 0 1 0 0 16a8 8 0 0 0 0-16zM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12zm5.793-4.207a1 1 0 0 1 1.414 0L12 10.586l2.793-2.793a1 1 0 1 1 1.414 1.414L13.414 12l2.793 2.793a1 1 0 0 1-1.414 1.414L12 13.414l-2.793 2.793a1 1 0 0 1-1.414-1.414L10.586 12L7.793 9.207a1 1 0 0 1 0-1.414z"/>
            </svg>

            <div class="mt-2 text-xl">Failed</div>
        @endif
    </x-container>

    @push('script')
    <script>
        setTimeout(function () {
            window.location.replace('{{ route('homepage') }}');
        }, {{ $success ? 500 : 2000 }});
    </script>
    @endpush
</x-main-layout>
