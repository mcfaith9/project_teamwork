<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
        <x-tabler-bell class="h-4 w-4 text-gray-800 dark:text-black" />
    </button>
    
    <div class="absolute z-10 right-0 mt-2 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5" x-show="open" @click.away="open = false">
        <label class="block mt-4 mb-2 text-sm font-medium text-center text-gray-900 dark:text-gray-800">Set a reminder for yourself</label>
        <div class="py-2" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="width: 14rem;">
            <a href="#" wire:click.prevent="selectedReminder('Later Today','{{now()->addHours(3)->format('Y-m-d')}}')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">
                        Later Today                        
                    </span>
                    <span class="inline-flex item-center ml-auto text-xs text-gray-400">{{ now()->addHours(3)->format('h:i A') }}</span>
                </div>
            </a>
            <a href="#" wire:click.prevent="selectedReminder('Tomorrow', '{{now()->addDays(1)->format('Y-m-d')}}')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">
                        Tomorrow                        
                    </span>
                    <span class="inline-flex item-center ml-auto text-xs text-gray-400">{{ now()->addDays(1)->format('D, M j') }}</span>
                </div>
            </a>
            <a href="#" wire:click.prevent="selectedReminder('Next Week', '{{now()->addWeeks(1)->format('Y-m-d')}}')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">
                        Next Week                        
                    </span>
                    <span class="inline-flex item-center ml-auto text-xs text-gray-400">{{ now()->addWeeks(1)->format('D, M j') }}</span>
                </div>
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" title="Coming Soon">
                <div class="text-sm text-gray-700 flex items-center">
                    <x-tabler-calendar class="mr-2 h-4 w-4 text-gray-800 dark:text-black" />
                    <span>
                        Custom Date
                    </span>                    
                </div>
            </a>   
        </div>
    </div>
</div>
