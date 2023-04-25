<x-filament::page>
    <div class="border-t border-gray-300 my-4"></div>
    
    <div class="flex items-center justify-between">
        <div class="inline-flex">
            <h1 class="filament-header-heading font-medium"> Reports </h1>
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


        <div class="min-w-full overflow-hidden rounded-lg shadow-xs">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        @foreach($workData as $data)
                            <th class="px-4 py-2 text-sm font-medium text-gray-500">
                                {{ $data['date'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        @foreach($workData as $data)
                            <td class="px-1 py-1 whitespace-nowrap">
                                <div class="progress-bar mb-6 h-px w-full bg-neutral-200 dark:bg-neutral-600">
                                    <div class="progress h-px" style="width: {{ $data['percentage'] }}"></div>
                                </div>
                                <p class="text-center text-sm text-gray-500">
                                    {{ $data['value'] }}
                                </p>
                            </td>
                        @endforeach                        
                    </tr>
                </tbody>
            </table>
        </div>
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

        .progress-bar {
          background-color: #eee;
          border-radius: 4px;
          height: 10px;
          margin: 10px 0;
        }

        .progress {
          background-color: #4caf50;
          height: 100%;
          border-radius: 4px;
        }
    </style>

</x-filament::page>
