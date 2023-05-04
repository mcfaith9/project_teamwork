<div x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
        <x-tabler-flag-3 class="h-4 w-4 text-gray-800 dark:text-black" />     
    </button>
    <div x-show="open" @click.away="open = false" class="absolute mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:click.prevent="selectedTaskFlag('High')">
                <x-tabler-flag-3 class="inline-flex h-4 w-4 mr-2" />High
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:click.prevent="selectedTaskFlag('Medium')">
                <x-tabler-flag-3 class="inline-flex h-4 w-4 mr-2" />Medium
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:click.prevent="selectedTaskFlag('Low')">
                <x-tabler-flag-3 class="inline-flex h-4 w-4 mr-2" />Low
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:click.prevent="selectedTaskFlag('None')">
                <x-tabler-flag-3 class="inline-flex h-4 w-4 mr-2" />None
            </a>
        </div>
    </div>
</div>