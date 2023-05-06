<div x-data="{ open: false }" class="relative">
    <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center" @click="open = !open">
        <x-tabler-tag class="h-4 w-4 text-gray-800 dark:text-black" />     
    </button>

    <div class="absolute z-10 right-0 mt-2 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5" x-show="open" @click.away="open = false">
        <div class="py-2 px-2" style="width: 14rem;">
            <label class="px-3 block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-800">Set tags</label>
            <select id="task_tags" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Choose a tag</option>
                <option value="OnHold"><span class="inline-block w-3 h-3 mr-2 rounded-full border-warning-600"></span>Status: OnHold</option>
                <option value="Pending"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-yellow-400"></span>Status: Pending</option>
                <option value="StagingDone"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-green-400"></span>Status: Staging Done</option>
                <option value="InDevelopment"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-blue-400"></span>Status: In Development</option>
                <option value="InTesting"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-blue-400"></span>Status: In Testing</option>
                <option value="Blocked"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-red-400"></span>Status: Blocked</option>
                <option value="Completed"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-green-400"></span>Status: Completed</option>
                <option value="BugFix"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-red-400"></span>Bug Fix</option>
                <option value="Testing"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-blue-400"></span>Testing</option>
                <option value="Deployment"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-green-400"></span>Deployment</option>
                <option value="CodeReview"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-blue-400"></span>Code Review</option>
                <option value="Documentation"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-blue-400"></span>Documentation</option>
                <option value="Maintenance"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-blue-400"></span>Maintenance</option>
                <option value="FeatureRequest"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-blue-400"></span>Feature Request</option>
                <option value="Backend"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-purple-400"></span>Backend Development</option>
                <option value="Frontend"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-purple-400"></span>Frontend Development</option>
                <option value="Database"><span class="inline-block w-3 h-3 mr-2 rounded-full bg-purple-400"></span>Database Development</option>
            </select>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script type="text/javascript">
    $('#task_tags').select2();
</script>