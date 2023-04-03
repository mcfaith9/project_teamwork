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
			<p class="text-black-500 dark:text-white mr-2">Total Worked Today: 00:00:00</p>
		</div>		
	</div>
    <ul id="task-list-item" class="bg-white border border-gray-200 divide-y divide-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <li class="py-4 px-4 flex dark:hover:bg-gray-500/10">
            <div class="flex items-center mr-4">
                <x-tabler-drag-drop-2 class="h-5 w-5 text-gray-400 cursor-move" style="cursor: grab!important" />
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Upskill Fimalament</h4>
                <p class="text-gray-500 dark:text-white">Boosting my skills with Filament's comprehensive learning resources.</p>
            </div>
            <div class="flex items-center">
                <div wire:ignore>
                    <p class="font-medium text-gray-500 dark:text-white mr-2" id="timer">00:00:00</p>
                </div>
                <button class="rounded-full bg-gray-200 text-gray-700 p-1 dark:bg-gray-900" id="timerBtn">
                   <x-heroicon-o-play class="clock-play h-7 w-7 dark:text-white" />
                </button>
            </div>
        </li>
        <li class="py-4 px-4 flex dark:hover:bg-gray-500/10">
            <div class="flex items-center mr-4">
                <x-tabler-drag-drop-2 class="h-5 w-5 text-gray-400 cursor-move" style="cursor: grab!important" />
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">List Item 2</h4>
                <p class="text-gray-500 dark:text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="flex items-center">
                <div wire:ignore>
                    <p class="font-medium text-gray-500 dark:text-white mr-2">00:00:00</p>
                </div>
                <button class="rounded-full bg-gray-200 text-gray-700 p-1 dark:bg-gray-900">
                    <x-heroicon-o-play class="clock-play h-7 w-7 dark:text-white" />
                </button>
            </div>
        </li>
        <li class="py-4 px-4 flex dark:hover:bg-gray-500/10">
            <div class="flex items-center mr-4">
                <x-tabler-drag-drop-2 class="h-5 w-5 text-gray-400 cursor-move" style="cursor: grab!important" />
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">List Item 3</h4>
                <p class="text-gray-500 dark:text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="flex items-center">
                <div wire:ignore>
                    <p class="font-medium text-gray-500 dark:text-white mr-2">00:00:00</p>
                </div>
                <button class="rounded-full bg-gray-200 text-gray-700 p-1 dark:bg-gray-900">
                    <x-heroicon-o-play class="h-7 w-7 dark:text-white" />
                </button>
            </div>
        </li>
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
                    console.log('should trigger ajax to save sequence')
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

	        var seconds = 0;
	        var minutes = 0;
	        var hours = 0;
	        var timerInterval;
	        var timerBtn = document.getElementById("timerBtn");
	        var startTime = 0;
	        var pauseTime = 0;
	        var totalElapsedTime = 0;

	        function startTimer() {
	          	startTime = Date.now() - totalElapsedTime;
	          	timerInterval = setInterval(function() {
		            var currentTime = Date.now();
		            totalElapsedTime = currentTime - startTime;
		            seconds = Math.floor((totalElapsedTime / 1000) % 60);
		            minutes = Math.floor((totalElapsedTime / (1000 * 60)) % 60);
		            hours = Math.floor((totalElapsedTime / (1000 * 60 * 60)) % 24);

		            var timer = document.getElementById("timer");
					timer.innerHTML =
					hours.toString().padStart(2, "0") +
					":" +
					minutes.toString().padStart(2, "0") +
					":" +
					seconds.toString().padStart(2, "0");
	          }, 1000);
	          timerBtn.innerHTML = `<x-heroicon-o-pause class="pause h-7 w-7 dark:text-white" />`;
	        }

	        function pauseTimer() {
	            clearInterval(timerInterval);
	            timerBtn.innerHTML = `<x-heroicon-o-play class="play h-7 w-7 dark:text-white" />`;
	            pauseTime = Date.now();
	            totalElapsedTime = pauseTime - startTime;

	            console.log("Elapsed time: " + (totalElapsedTime / 1000) + " seconds");
	        }

	        timerBtn.addEventListener("click", function() {
				if (!timerInterval) {
					startTimer();
				} else if (timerBtn.innerHTML.includes("pause")) {
					pauseTimer();
				} else if (timerBtn.innerHTML.includes("play")) {
					startTimer();
				}
	        });
        })
    </script>
</x-filament::page>
