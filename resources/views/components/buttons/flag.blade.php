@php
    $flag = $task->attribute()->pluck('flag')->first();
    $bgClass = '';
    $textClass = '';
    switch ($flag) {
        case 'High':
            $bgClass = 'bg-danger-500';
            $textClass = 'text-white';
            break;
        case 'Medium':
            $bgClass = 'bg-warning-500';
            $textClass = 'text-gray-900';
            break;
        case 'Low':
            $bgClass = 'bg-success-500';
            $textClass = 'text-white';
            break;
        default:
            $bgClass = 'bg-gray-200';
            $textClass = 'text-gray-800';
            break;           
    }
@endphp

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="{{ $bgClass }} text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full flex items-center justify-center">
        <x-tabler-flag-3 class="h-4 w-4 {{ $textClass }} dark:text-black" />     
    </button>
    <div x-show="open" @click.away="open = false" class="absolute z-10 right-0 mt-2 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5" >
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="width: 8rem;">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:click.prevent="selectedTaskFlag('High')">
                <x-tabler-flag-3 class="inline-flex items-center p-1 bg-danger-500 rounded-full h-6 w-6 mr-2 text-white" />High
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:click.prevent="selectedTaskFlag('Medium')">
                <x-tabler-flag-3 class="inline-flex items-center p-1 bg-warning-500 rounded-full h-6 w-6 mr-2" />Medium
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:click.prevent="selectedTaskFlag('Low')">
                <x-tabler-flag-3 class="inline-flex items-center p-1 bg-success-500 rounded-full h-6 w-6 mr-2 text-white" />Low
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" wire:click.prevent="selectedTaskFlag('None')">
                <x-tabler-flag-3 class="inline-flex items-center p-1 bg-gray-200 rounded-full h-6 w-6 mr-2" />None
            </a>
        </div>
    </div>
</div>