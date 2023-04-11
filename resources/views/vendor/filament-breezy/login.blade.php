<x-filament-breezy::auth-card action="authenticate">

    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament::login.heading') }}
        </h2>
        @if(config("filament-breezy.enable_registration"))
        <p class="mt-2 text-sm text-center">
            {{ __('filament-breezy::default.or') }}
            <a class="text-primary-600" href="{{route(config('filament-breezy.route_group_prefix').'register')}}">
                {{ strtolower(__('filament-breezy::default.registration.heading')) }}
            </a>
        </p>
        @endif
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{route(config('filament-breezy.route_group_prefix').'password.request')}}">{{ __('filament-breezy::default.login.forgot_password_link') }}</a>
    </div>

    <div class="border-t border-gray-300 my-4"></div>
    <h1 class="text-center">Sign in with social media</h1>
    <div class="flex items-center justify-center space-x-4">
        <span class="iconify w-8 h-8 text-center" data-icon="flat-color-icons:google"></span>
        <span class="iconify w-8 h-8 text-center" data-icon="logos:github-icon"></span>
        <span class="iconify w-8 h-8 text-center" data-icon="logos:facebook"></span>
    </div>

</x-filament-breezy::auth-card>
