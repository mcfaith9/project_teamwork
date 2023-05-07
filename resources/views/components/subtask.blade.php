<div x-data="{ open: false }">
    <div class="py-3">
        @if(!$task->subtasks->isEmpty())
            <button @click="open = !open" class="flex justify-between items-center">
                <span class="font-medium mr-1 italic text-sm">Show Subtask ({{ count($task->subtasks) }})</span>     
            </button>
            <div x-show="open" class="bg-white p-4 rounded-lg">
                <div style="border-left: 4px solid #e2e8f0; padding: 1rem;">
                    @if(!$task->subtasks->isEmpty())
                        @foreach($task->subtasks as $sub)
                            <h2 class="font-bold mb-2 dark:text-white">{{ $sub->title }}</h2>
                            <p class="text-gray-700 mb-4 dark:text-gray-300">{{ $sub->description }}</p>
                        @endforeach
                    @endif
                </div>            
            </div>
        @else
            <span class="font-medium mr-1 italic text-sm">No Subtask ({{ count($task->subtasks) }})</span>  
        @endif
        
    </div>
</div>