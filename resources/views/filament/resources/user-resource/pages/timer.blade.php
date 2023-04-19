<x-filament::page>
	<div class="flex justify-between items-center">
		<div class="text-left">
			<div class="relative group max-w-md">
				<span class="absolute inset-y-0 left-0 flex items-center justify-center w-10 h-10 text-gray-500 pointer-events-none group-focus-within:text-primary-500 dark:text-gray-400">
					<x-tabler-search class="w-5 h-5" />
				</span>
				<input placeholder="Search Task" id="timerSearchTaskInput" autocomplete="off" class="block w-full h-10 pl-10 bg-gray-400/10 placeholder-gray-500 border-transparent transition duration-75 rounded-lg outline-none focus:bg-white focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400">
			</div>
		</div>
		<div class="text-right">
			<p class="text-black-500 dark:text-white mr-2">Total Worked Today: 
                <b id="totalWorkedToday">
                    {{ $totalTimeLog }}
                </b>
            </p>
		</div>		
	</div>

    <div class="border-t border-gray-300 my-4"></div>

    <ul id="task-list-item" class="bg-white border border-gray-200 divide-y divide-gray-200 dark:bg-gray-800 dark:border-gray-700">
    	@foreach ($tasks as $task)            
                <li class="py-4 px-4 flex dark:hover:bg-gray-500/10" id="{{ $task['id'] }}">
                    <div class="flex items-center mr-4">
                        <x-tabler-drag-drop-2 class="h-5 w-5 text-gray-400 cursor-move" style="cursor: grab!important" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $task['title'] }}</h4>
                        <p class="text-gray-500 dark:text-white pr-1">{{ $task['description'] }}</p>
                    </div>
                    <div class="flex items-center">
                        <div wire:ignore>
                            @if(!$task['prev_time_today'] == 0)
                                @foreach ($task['prev_time_today'] as $timeLog)
                                    @if(isset($timeLog['pivot']['prev_time_today']))
                                        <p class="font-medium text-gray-500 dark:text-white mr-2" id="timer{{ $task['id'] }}">{{ \Carbon\CarbonInterval::milliseconds($timeLog['pivot']['prev_time_today'])->cascade()->format('%H:%I:%S') }}</p>
                                    @else 
                                        <p class="font-medium text-gray-500 dark:text-white mr-2" id="timer{{ $task['id'] }}">00:00:00</p>
                                    @endif
                                @endforeach  
                            @else
                                <p class="font-medium text-gray-500 dark:text-white mr-2" id="timer{{ $task['id'] }}">00:00:00</p>
                            @endif 
                        </div>
                        <button class="rounded-full bg-gray-200 text-gray-700 p-1 dark:bg-gray-900" data-id="{{ $task['id'] }}" id="timerBtn_{{ $task['id'] }}">
                            <x-heroicon-o-play class="h-7 w-7 dark:text-white" />
                        </button>
                    </div>
                </li>             	    
    	@endforeach
    </ul>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            // Get <ul> task-list-item
            var el = document.getElementById('task-list-item');

            // List with handle
            var sortable = Sortable.create(el, {
                animation: 150,
                handle: '.cursor-move',
                onEnd: function (evt) {
                    var listItems = evt.from.children;
                    var sequence = [];
                    for (var i = 0; i < listItems.length; i++) {
                        sequence.push(listItems[i].getAttribute('id'));
                    }
                    // you can now send an AJAX request to save the new sequence
                    $.ajax({
                        url: '/tasks/store-sequence',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            sequence: sequence,
                        },
                        success: function (data) {
                            console.log('/tasks/store-sequence =>', data);
                        },
                        error: function (xhr, status, error) {
                            console.error('/tasks/store-sequence =>', error);
                        }
                    });
                }
            });

            const searchInput = document.getElementById("timerSearchTaskInput");
			const listItems = document.querySelectorAll("#task-list-item li");

			searchInput.addEventListener("input", (event) => {
				const searchTerm = event.target.value.toLowerCase();
				listItems.forEach((item) => {
					const title = item.querySelector("h4").textContent.toLowerCase();
					const description = item.querySelector("p").textContent.toLowerCase();

					if (title.indexOf(searchTerm) > -1 || description.indexOf(searchTerm) > -1) {
						item.style.display = "flex";
					} else {
						item.style.display = "none";
					}
				});
			});

			document.addEventListener("DOMContentLoaded", function() {
				let timers = {};
				let elapsedTimes = {};

			  	// Listen for clicks on timer buttons
				document.querySelectorAll('[id^="timerBtn_"]').forEach(button => {
					button.addEventListener('click', function() {

						const id = button.getAttribute('data-id');
						let timer = timers[id];

			      		// If another timer is already running, pause it
						const runningTimer = Object.values(timers).find(t => t && !t.paused && t.timerId !== timer?.timerId);
						if (runningTimer) {
							clearInterval(runningTimer.timerId);
							runningTimer.elapsed = new Date().getTime() - runningTimer.startTime;
							runningTimer.paused = true;
							document.querySelector(`#timerBtn_${runningTimer.id}`).innerHTML = `<x-heroicon-o-play class="h-7 w-7 dark:text-white" />  `;
						}
						if (!timer || timer.paused) {

			        		// Get previous time in milliseconds and add it to the start time
    		                const previousTime = button.closest('li').querySelector('#timer' + id)?.textContent.trim();
    		                const previousTimeInMs = previousTime ? previousTime.split(':').reduce((acc, time) => (60 * acc) + +time, 0) * 1000 : 0;
    		                const start = timer && timer.elapsed ? new Date().getTime() - timer.elapsed : new Date().getTime() - previousTimeInMs;
    		                
							timers[id] = {
								id: id,
								startTime: start,
								timerId: setInterval(function() {
									const now = new Date().getTime();
									const distance = now - start;
									const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
									const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
									const seconds = Math.floor((distance % (1000 * 60)) / 1000);
									const timerEl = document.querySelector(`#timer${id}`);
									timerEl.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
			            			// Update elapsed time
									elapsedTimes[id] = distance;
									const totalElapsed = Object.values(elapsedTimes).reduce((acc, val) => acc + val, 0);
									const totalElapsedEl = document.querySelector('#totalWorkedToday');
									totalElapsedEl.innerHTML = `${Math.floor(totalElapsed / (1000 * 60 * 60)).toString().padStart(2, '0')}:${Math.floor((totalElapsed % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0')}:${Math.floor((totalElapsed % (1000 * 60)) / 1000).toString().padStart(2, '0')}`;
								}, 1000),
								paused: false,
								elapsed: timer ? timer.elapsed : 0
							};
							button.innerHTML = `<x-heroicon-o-pause class="h-7 w-7 dark:text-white" />`;

                            storeTimeLog(id, elapsedTimes[id]);

						} else {

			        		// Pause the timer
							clearInterval(timer.timerId);
							timer.elapsed = new Date().getTime() - timer.startTime;
							timer.paused = true;
							button.innerHTML = `<x-heroicon-o-play class="h-7 w-7 dark:text-white" />`;

			        		// Update elapsed time
							elapsedTimes[id] = timer.elapsed;
							const totalElapsed = Object.values(elapsedTimes).reduce((acc, val) => acc + val, 0);

                            storeTimeLog(id, timer.elapsed);
						}

                        function storeTimeLog(taskId, elapsed) {
                            // Make an AJAX call to save the data
                            $.ajax({
                                url: "{{ route('task_time_log.store') }}",
                                method: "POST",
                                data: {
                                    task_id: taskId,
                                    user_id: "{{ Auth::id() }}",
                                    prev_time_today: elapsed,
                                    time_log: elapsed,
                                    _token: "{{ csrf_token() }}"
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown); // Handle any errors
                            });
                        } // end storeTimeLog  

					}); 
				});
			});

			// end
        });
    </script>
</x-filament::page>
