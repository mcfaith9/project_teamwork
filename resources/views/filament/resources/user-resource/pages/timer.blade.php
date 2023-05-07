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
                        <a href="{{ url('/app/tasks/' . $task['id']) }}" target="_blanks">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $task['title'] }}
                                <x-tabler-external-link class="mb-2 inline-flex h-4 w-4 text-gray-400"/>
                            </h4>
                        </a>
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
                        <button class="timer-button rounded-full bg-gray-200 text-gray-700 p-1 dark:bg-gray-900" data-id="{{ $task['id'] }}" id="timerBtn_{{ $task['id'] }}">
                            <x-heroicon-o-play class="h-7 w-7 dark:text-white" />
                        </button>
                    </div>
                </li>             	    
    	@endforeach
    </ul>

    <script type="text/javascript" src="{{ asset('js/tasktimer.min.js') }}"></script>
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

            // Get the search input element and all the list items in the task list
            const searchInput = document.getElementById("timerSearchTaskInput");
            const listItems = document.querySelectorAll("#task-list-item li");

            // Listen for input events on the search input
            searchInput.addEventListener("input", (event) => {
                // Get the search term entered by the user and convert it to lowercase
                const searchTerm = event.target.value.toLowerCase();
                
                // Loop through all the list items
                listItems.forEach((item) => {
                    // Get the title and description of the current list item and convert them to lowercase
                    const title = item.querySelector("h4").textContent.toLowerCase();
                    const description = item.querySelector("p").textContent.toLowerCase();

                    // If the search term is found in either the title or the description, show the list item
                    if (title.indexOf(searchTerm) > -1 || description.indexOf(searchTerm) > -1) {
                        item.style.display = "flex";
                    } 
                    // Otherwise, hide the list item
                    else {
                        item.style.display = "none";
                    }
                });
            });

            // Start Timer Logic (dirty approach)
            const { TaskTimer } = tasktimer;

            // Function to format duration in milliseconds as "HH:MM:SS"
            function formatTime(milliseconds) {
                const seconds = Math.floor(milliseconds / 1000);
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                const remainingSeconds = seconds % 60;
                return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
            }

            // Get all timer buttons and initialize variables
            const timerButtons = document.querySelectorAll('.timer-button');
            let currentTimer;
            let currentTimerId;
            let totalElapsedTime = 0;

            timerButtons.forEach((button) => {
                const taskId = button.dataset.id;
                const timerDisplay = document.getElementById(`timer${taskId}`);
                let timerPaused = true;
                let elapsedTime = 0;

                // Check if the timer display already has a value
                const initialElapsedTime = timerDisplay.textContent.trim();
                if (initialElapsedTime) {
                    elapsedTime = new Date(`1970-01-01T${initialElapsedTime}Z`).getTime();
                    timerDisplay.textContent = initialElapsedTime;
                }

                button.addEventListener('click', () => {
                    // If a timer is already running, stop it first
                    if (currentTimerId !== taskId) {
                        stopCurrentTimer();
                        saveElapsedTimeToServer(taskId, elapsedTime);
                    }

                    if (timerPaused) {
                        timerPaused = false;
                        if (!currentTimer) {
                            currentTimer = new TaskTimer(1000);
                            // Update total elapsed time in tick handler
                            currentTimer.on('tick', () => {
                                elapsedTime += currentTimer.interval;
                                timerDisplay.textContent = formatTime(elapsedTime);

                                // Update total elapsed time
                                totalElapsedTime += currentTimer.interval;
                                document.getElementById('totalWorkedToday').textContent = formatTime(totalElapsedTime);
                            });

                            // Check if the totalWorkedToday element already has a value
                            const totalWorkedTodayElement = document.getElementById('totalWorkedToday');
                            const initialTotalElapsedTime = totalWorkedTodayElement.textContent.trim();
                            if (initialTotalElapsedTime) {
                                totalElapsedTime = new Date(`1970-01-01T${initialTotalElapsedTime}Z`).getTime();
                                totalWorkedTodayElement.textContent = initialTotalElapsedTime;
                            }
                        }
                        currentTimer.start();
                        button.innerHTML = `<x-heroicon-o-pause class="h-7 w-7 dark:text-white" />`;

                        // Set the current running timer
                        currentTimerId = taskId;
                    } else {
                        timerPaused = true;
                        currentTimer.stop();
                        button.innerHTML = `<x-heroicon-o-play class="h-7 w-7 dark:text-white" />`;
                        saveElapsedTimeToServer(taskId, elapsedTime);
                    }
                });
            });

            function stopCurrentTimer() {
                if (currentTimer) {
                    currentTimer.stop();
                    const currentTimerButton = document.getElementById(`timerBtn_${currentTimerId}`);
                    currentTimerButton.innerHTML = `<x-heroicon-o-play class="h-7 w-7 dark:text-white" />`;
                    currentTimer = null;
                }
            }

            function saveElapsedTimeToServer(taskId, elapsedTime) {
                // Make an AJAX call to save the data
                $.ajax({
                    url: "{{ route('task_time_log.store') }}",
                    method: "POST",
                    data: {
                        task_id: taskId,
                        user_id: "{{ Auth::id() }}",
                        prev_time_today: elapsedTime,
                        time_log: elapsedTime,
                        _token: "{{ csrf_token() }}"
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown); // Handle any errors
                });
            }
            // end timer logic
        });
    </script>
</x-filament::page>
