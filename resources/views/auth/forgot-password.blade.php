@section('title', 'Forgot Password')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <section class="max-w-screen-sm mx-auto px-4 md:px-0 my-16">
        <div class="py-6 mx-auto">
            <x-card class="px-3 py-4 border-t-4 border-primary" title="Forgot your password?" titleSize="text-4xl font-semibold">
                <div class="mb-4 text-base text-gray-600">
                    No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </div>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div>
                        <label for="email" class="whitespace-nowrap font-medium required">Email</label>
                        <input
                            id="email"
                            type="text"
                            name="email"
                            class="input w-full text-md ring-1 ring-gray-300 px-4 py-1 my-2 appearance-none hover:ring-2 hover:ring-accent/50 focus:ring-2 focus:ring-accent/50 focus:outline-none"
                            value="{{ old('email') }}"
                            autofocus
                        >
                    </div>

                    <div class="mt-2">
                        <x-auth-session-status :status="session('status')" />
                        <x-auth-validation-errors :errors="$errors" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button>{{ __('Email Password Reset Link') }}</x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </section>
</x-main-layout>
