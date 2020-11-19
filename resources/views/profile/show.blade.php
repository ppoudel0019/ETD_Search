

    

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <form method="POST" action="/history">
            @csrf
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-jet-button class="ml-4">
                 {{ __('History') }}
                </x-jet-button>
                </form>
                </div>
    
  
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('profile.update-profile-information-form')

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <x-jet-section-border />
            
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>
            @endif




            
        </div>
    </div>
</x-app-layout>
