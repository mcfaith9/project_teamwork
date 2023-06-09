<div wire:ignore class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
        <x-css-sand-clock class="h-4 w-4 text-gray-800 dark:text-black" />
    </button>
    
    <div class="absolute z-10 right-0 mt-2 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5" x-show="open" @click.away="open = false">
        <div class="bg-white rounded-md p-4 text-center" style="width: 14rem;">
            <label class="block mb-2 text-sm font-medium text-center text-gray-900 dark:text-gray-800">Estimate Time</label>
            <input id="estimate{{ $this->id }}" class="border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md w-full py-2 px-3 mb-4 leading-tight text-gray-900 dark:text-gray-800" type="text" placeholder="00:00">
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.getElementById("estimate{{ $this->id }}").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        time_24hr: false,
        static: true,
        confirmText: "OK ",
        showAlways: false,
        onClose: function(selectedDates, dateStr, instance) {
            @this.call('storeEstimateTime', dateStr);
        }
    });
</script>