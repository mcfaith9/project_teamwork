<x-filament::page>
    <div class="flex justify-between items-center">
        <div class="text-left">
            <div class="relative group max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center justify-center w-10 h-10 text-gray-500 pointer-events-none group-focus-within:text-primary-500 dark:text-gray-400">
                    <x-tabler-search class="w-5 h-5" />
                </span>
                <input placeholder="Assignee / Task Name" id="#" autocomplete="off" class="block w-full h-10 pl-10 bg-gray-400/10 placeholder-gray-500 border-transparent transition duration-75 rounded-lg outline-none focus:bg-white focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400">
            </div>
        </div>    
        <div class="text-right">
            <div class="items-center justify-center hidden col-span-1 space-x-2 sm:flex">
                <button class="flex items-center p-2 text-xs font-medium rounded-lg bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 outline-none text-white">                   
                    <x-tabler-sort-ascending-2 class="w-5 h-5" />
                </button>
                
                <button class="flex items-center p-2 text-xs font-medium rounded-lg bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 outline-none text-white">
                    <span class="sr-only">Toggle tablet view</span>

                    <x-tabler-list-details class="w-5 h-5" />
                </button>     

                <button class="flex items-center p-2 text-xs font-medium rounded-lg bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 outline-none text-white">
                    <x-tabler-table class="w-5 h-5" />
                </button>

                <button type="button" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                    <x-tabler-list-check class="w-5 h-5" /> Personal Task
                </button>
              
            </div>
        </div>  
    </div>
    <div class="border-t border-gray-300 my-4"></div>
</x-filament::page>
