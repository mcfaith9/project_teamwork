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

	<div class="grid grid-cols-12 gap-4">
	    <div class="col-span-9">
	        <ul class="border-gray-200 divide-y divide-gray-200 space-y-1">
	            @foreach($taskWork as $work)
	                <li class="flex items-center justify-between py-4 px-6 bg-white rounded-xl hover:bg-gray-100">
	                    <div class="flex items-center">
	                        <div class="h-10 w-10 bg-gray-300 rounded-md mr-4"></div>
	                        <div>
	                            <p class="text-gray-900 font-medium dark:text-black">{{ $work->title }}</p>
	                        </div>
	                    </div>
	                    <div class="flex items-center space-x-2">
	                        <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
	                            <x-tabler-arrow-up-right class="h-4 w-4 text-gray-800 dark:text-black" />
	                        </button>
	                        <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
	                            <x-heroicon-s-chat class="h-4 w-4 text-gray-800 dark:text-black" />       
	                        </button>
	                        <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
	                            <x-tabler-eye class="h-4 w-4 text-gray-800 dark:text-black" />     
	                        </button>

                            <button class="tooltip inline-block flex items-center" title="More Details..." onclick="toggleDetails({{ $work->id }})">
                                <x-css-details-more class="h-5 w-5 text-gray-800 dark:text-black" />
                            </button>

	                        <div id="details_{{ $work->id }}" class="flex items-center justify-between space-x-2 hidden">
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
	                </li> 
	            @endforeach
	        </ul>
	    </div>
	    <div class="col-span-3">
	        <h1 class="text-gray-900 font-medium dark:text-white">Milestones</h1>
	        <p class="dark:text-whit">You have no milestones due today</p>
	        <div class="border-t border-gray-300 my-4"></div>
	        <h1 class="text-gray-900 font-medium dark:text-white">Events</h1>
	        <p class="dark:text-whit">You have no events scheduled today</p>
	    </div>
	</div>


    <script>
    function toggleDetails(workId) {
        const details = document.querySelector(`#details_${workId}`);
        details.classList.toggle('hidden');
    }
    </script>

</x-filament::page>
