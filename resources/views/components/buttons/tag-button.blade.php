<div x-data="{ open: false }" class="relative">
    <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 justify-center" @click="open = !open">
        <x-tabler-tag class="h-4 w-4 text-gray-800 dark:text-black" />     
    </button>

    <div class="absolute z-10 right-0 mt-2 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5" x-show="open" @click.away="open = false">
        <div class="py-2 px-2">
            <label class="px-3 block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-800">Set tags</label>
            <select id="task_tags" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" style="width: 15rem;">
                <option selected>Choose a tag</option>
                <option value="OnHold">Status: OnHold</option>
                <option value="Pending">Status: Pending</option>
                <option value="StagingDone">Status: Staging Done</option>
                <option value="InDevelopment">Status: In Development</option>
                <option value="InTesting">Status: In Testing</option>
                <option value="Blocked">Status: Blocked</option>
                <option value="Completed">Status: Completed</option>
                <option value="BugFix">Bug Fix</option>
                <option value="Testing">Testing</option>
                <option value="Deployment">Deployment</option>
                <option value="CodeReview">Code Review</option>
                <option value="Documentation">Documentation</option>
                <option value="Maintenance">Maintenance</option>
                <option value="FeatureRequest">Feature Request</option>
                <option value="Backend">Backend Development</option>
                <option value="Frontend">Frontend Development</option>
                <option value="Database">Database Development</option>
            </select>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript">
    $('#task_tags').select2({
        templateResult: formatState,
        templateSelection: formatState
    });

    function formatState (state) {
        if (!state.id) { return state.text; }
        var $state = $(
            '<span class="color-circle inline-flex items-center p-1 bg-danger-500 rounded-full h-4 w-4 mr-2"></span> <label>' + state.text + '</label></span>'
        );
        return $state;
    }
</script>