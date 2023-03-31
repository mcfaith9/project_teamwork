<x-filament::page>
    <ul id="task-list-item" class="bg-white border border-gray-200 divide-y divide-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <!-- List Item 1 -->
        <li class="py-4 px-4 flex dark:hover:bg-gray-500/10">
            <div class="flex items-center mr-4">
                <x-tabler-drag-drop-2 class="h-5 w-5 text-gray-400 cursor-move" />
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Upskill Fimalament</h4>
                <p class="text-gray-500 dark:text-white">Boosting my skills with Filament's comprehensive learning resources.</p>
            </div>
            <div class="flex items-center">
                <button class="rounded-full bg-gray-200 text-gray-700 p-2 dark:bg-gray-900">
                   <x-tabler-clock-play class="h-8 w-8 dark:text-white" />
                </button>
            </div>
        </li>
        <!-- List Item 2 -->
        <li class="py-4 px-4 flex dark:hover:bg-gray-500/10">
            <div class="flex items-center mr-4">
                <x-tabler-drag-drop-2 class="h-5 w-5 text-gray-400 cursor-move" />
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">List Item 2</h4>
                <p class="text-gray-500 dark:text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="flex items-center">
                <button class="rounded-full bg-gray-200 text-gray-700 p-2 dark:bg-gray-900">
                    <x-tabler-clock-play class="h-8 w-8 dark:text-white" />
                </button>
            </div>
        </li>
        <!-- List Item 3 -->
        <li class="py-4 px-4 flex dark:hover:bg-gray-500/10">
            <div class="flex items-center mr-4">
                <x-tabler-drag-drop-2 class="h-5 w-5 text-gray-400 cursor-move" />
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">List Item 3</h4>
                <p class="text-gray-500 dark:text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="flex items-center">
                <button class="rounded-full bg-gray-200 text-gray-700 p-2 dark:bg-gray-900">
                    <x-tabler-clock-play class="h-8 w-8 dark:text-white" />
                </button>
            </div>  
        </li>
    </ul>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
    <script>
        var el = document.getElementById('task-list-item');
        var sortable = Sortable.create(el, {
            animation: 150
        });
    </script>
</x-filament::page>
