<x-filament::page>

    <div class="bg-white shadow-lg rounded-lg px-6 py-4 dark:bg-gray-800">
        <h2 class="text-2xl font-bold mb-2 dark:text-white">{{ $data['title'] }}</h2>
        <p class="text-gray-700 mb-4 dark:text-gray-300">{{ $data['description'] }}</p>

        <div class="border-t border-gray-300 mt-4"></div>
        <div class="flex flex-wrap mt-4">
            @foreach($data['users'] as $user)
                <span class="inline-block rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-4 bg-gray-300">
                    <div class="flex items-center">
                        <x-heroicon-s-user class="text-gray-500 mr-2 w-4 h-4"/>
                        <span>{{ $user->name }}</span>
                    </div>
                </span>
            @endforeach

            <div class="flex items-center space-x-2 ml-auto">
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-tabler-calendar-event class="h-4 w-4 text-gray-800 dark:text-black" />
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-css-sand-clock class="h-4 w-4 text-gray-800 dark:text-black" />    
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-tabler-bell class="h-4 w-4 text-gray-800 dark:text-black" />     
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-tabler-tag class="h-4 w-4 text-gray-800 dark:text-black" />     
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-tabler-flag-3 class="h-4 w-4 text-gray-800 dark:text-black" />     
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <span>0%</span>      
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg px-6 py-4 dark:bg-gray-800">       

        <form class="mb-4" wire:submit.prevent="submit">
            {{ $this->form }}
            <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline dark:bg-blue-700 dark:hover:bg-blue-900 dark:text-white dark:border-blue-700" type="submit">Submit</button>
        </form>
    </div>

</x-filament::page>
