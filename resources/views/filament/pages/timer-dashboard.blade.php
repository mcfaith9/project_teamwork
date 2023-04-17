<x-filament::page>
    <div class="border-t border-gray-300 my-4"></div>
    
    <div class="flex items-center justify-between">
        <div class="inline-flex">
            <h2> Reports </h2>
        </div>

        <div class="flex items-center justify-end">
            <div class="inline-flex rounded-md shadow-sm">
                <a href="#" aria-current="page" class="inline-flex items-center justify-center py-1 gap-1 font-medium rounded-l-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                    <span>Day</span>
                </a>
                <a href="#" class="inline-flex items-center justify-center py-1 gap-1 font-medium border-l-0 border-r-0 transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                    <span>Week</span>
                </a>
                <a href="#" class="inline-flex items-center justify-center py-1 gap-1 font-medium border-l-0 border-r-0 transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                    <span>Month</span>
                </a>
                <a href="#" class="inline-flex items-center justify-center py-1 gap-1 font-medium rounded-r-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                    <span>Date Range</span>
                </a>
            </div>
        </div>
    </div>

    <x-filament::card>
        <span>Timesheet</span>

    </x-filament::card>
    
    <style type="text/css">
        .rounded-l-lg {
          border-top-left-radius: 0.5rem;
          border-bottom-left-radius: 0.5rem;
        }

        .rounded-r-lg {
          border-top-right-radius: 0.5rem;
          border-bottom-right-radius: 0.5rem;
        }
    </style>
    
</x-filament::page>
