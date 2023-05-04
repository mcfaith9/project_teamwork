<div x-data="{ open: false, value: {{ $data->attribute()->pluck('progress')->first() ?? 0 }} }">
    <div class="relative">
        <button @click="open = !open" class="text-sm font-semibold flex items-center text-gray-800 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
            <span x-text="value + '%'"></span>  
        </button>
        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="px-6 py-2" style="width: 200px;">
                <label for="slider" class="block mb-2 text-sm font-medium text-center text-gray-900 dark:text-gray-800">
                    Set Progress: <span x-text="value + '%'"></span>
                </label>
                <input id="slider" type="range" max="99" x-model="value" wire:model="progressValue" wire:change="selectedProgressValue" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
            </div>
        </div>
    </div>
</div>
