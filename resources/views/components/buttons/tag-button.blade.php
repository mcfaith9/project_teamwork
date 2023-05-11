@php
    $statuses = [
        'OnHold' => 'Status: OnHold',
        'Pending' => 'Status: Pending',
        'StagingDone' => 'Status: Staging Done',
        'InDevelopment' => 'Status: In Development',
        'InTesting' => 'Status: In Testing',
        'Blocked' => 'Status: Blocked',
        'Completed' => 'Status: Completed',
        'BugFix' => 'Bug Fix',
        'Testing' => 'Testing',
        'Deployment' => 'Deployment',
        'CodeReview' => 'Code Review',
        'Documentation' => 'Documentation',
        'Maintenance' => 'Maintenance',
        'FeatureRequest' => 'Feature Request',
        'Backend' => 'Backend Development',
        'Frontend' => 'Frontend Development',
        'Database' => 'Database Development',
    ];
@endphp

<div wire:ignore x-data="{ open: false }" class="relative">
    <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 justify-center" @click="open = !open">
        <x-tabler-tag class="h-4 w-4 text-gray-800 dark:text-black" />     
    </button>

    <div class="absolute z-10 right-0 mt-2 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5" x-show="open" @click.away="open = false">
        <div class="py-2 px-2">
            <label class="px-3 block mt-2 mb-2 text-sm font-medium text-gray-900 dark:text-gray-800">Set tags</label>
            <select id="task_tags" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @foreach ($statuses as $value => $text)
                    <option value="{{ $value }}" @if($value == $tag) selected @endif>{{ $text }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript">
    const colorMap = {
        OnHold: "#EF4444",
        Pending: "#FBBF24",
        StagingDone: "#C084FC",
        InDevelopment: "#60A5FA",
        InTesting: "#3B82F6",
        Blocked: "#DB2777",
        Completed: "#10B981",
        BugFix: "#D97706",
        Testing: "#4B5563",
        Deployment: "#374151",
        CodeReview: "#6B7280",
        Documentation: "#9CA3AF",
        Maintenance: "#F59E0B",
        FeatureRequest: "#7C3AED",
        Backend: "#1E3A8A",
        Frontend: "#047857",
        Database: "#6D4C41",
    };

    function formatState(state) {
      if (!state.id) {
        return state.text;
      }
      const color = colorMap[state.id];
      if (!color) {
        return state.text;
      }
      const $state = $(`<div class="flex items-center py-1">
          <span class="color-circle inline-flex items-center p-1 rounded-full h-4 w-4 mr-2" style="background-color: ${color}"></span>
          <label class="text-sm font-medium text-gray-900 dark:text-gray-800">${state.text}</label>
          </div>`);
      return $state;
    }

    $('#task_tags').select2({
        width: 'resolve',
        placeholder: 'Select an tag\'s',
        templateResult: formatState,
        templateSelection: formatState,
        destroy: false,
    }).on('change', function (e) {
        @this.call('attachSelectedTag', $(this).find('option:selected').text());
    });

    // Add @click.stop modifier to prevent event from bubbling up to button
    $('#task_tags').on('select2:open', function (e) {
        $('.select2-search__field').on('click', function(e) {
            e.stopPropagation();
        });
    });   
</script>