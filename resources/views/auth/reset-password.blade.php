@section('title', 'Reset Password')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <section class="max-w-screen-sm mx-auto px-4 md:px-0 my-16">
        <div class="py-6 mx-auto">
            <x-card class="px-3 py-4 border-t-4 border-primary" title="Reset password" titleSize="text-4xl font-semibold">
                <div class="mb-4 text-base text-gray-600">
                    Please enter your email and a new password.
                    Then you will be able to login with it to your account.
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="whitespace-nowrap font-medium required">Email</label>
                        <input
                            id="email"
                            type="text"
                            name="email"
                            class="input w-full text-md ring-1 ring-gray-300 px-4 py-1 my-2 appearance-none hover:ring-2 hover:ring-accent/50 focus:ring-2 focus:ring-accent/50 focus:outline-none"
                            value="{{ old('email', $request->email) }}"
                            autofocus
                        >
                    </div>

                    <div class="mt-4">
                        <label for="password" class="whitespace-nowrap font-medium required">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="input w-full text-md ring-1 ring-gray-300 px-4 py-1 my-2 appearance-none hover:ring-2 hover:ring-accent/50 focus:ring-2 focus:ring-accent/50 focus:outline-none"
                        >
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation" class="whitespace-nowrap font-medium required">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="input w-full text-md ring-1 ring-gray-300 px-4 py-1 my-2 appearance-none hover:ring-2 hover:ring-accent/50 focus:ring-2 focus:ring-accent/50 focus:outline-none"
                        >
                    </div>

                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    <div class="flex items-center justify-end mt-4">
                        <x-button>{{ __('Reset Password') }}</x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </section>
</x-main-layout>
