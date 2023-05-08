<div class="relative" x-task="{ open: false }">
    <button @click="open = !open" class="text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
        <x-tabler-calendar-event class="h-4 w-4 text-gray-800 dark:text-black" />
    </button>
    
    <div class="absolute z-10 right-0 mt-2 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5" x-show="open" @click.away="open = false">
        <div class="bg-white rounded-md p-4 text-center" style="width: 15rem;">
            <label class="block mb-2 text-sm font-medium text-center text-gray-900 dark:text-gray-800">Pick Start Date and Due Date</label>
            <input id="datepicker{{ $this->id }}" class="border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md w-full py-2 px-3 mb-4 leading-tight text-gray-900 dark:text-gray-800" type="text" placeholder="Select Date Range">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
<script>
    //start Daterange
    const rangePicker = new easepick.create({
        element: document.getElementById('datepicker{{ $this->id }}'),
        css: [
            'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
        ],
        plugins: ['RangePlugin', 'LockPlugin'],
        LockPlugin: {
            // minDate: new Date(),
        },
        setup(rangePicker) {
            rangePicker.on('select', (e) => {
                let start = e.detail.start;
                let end = e.detail.end;

                @this.set('start', e.detail.start.format('YYYY-MM-DD'));
                @this.set('end', e.detail.end.format('YYYY-MM-DD'));
                @this.call('storeSelectedDateRange');
            });
        }
    });

    let start_date = "{{ $task->attribute()->pluck('start_date')->first() }}";
    let due_date = "{{ $task->attribute()->pluck('due_date')->first() }}";
    rangePicker.setDateRange(start_date, due_date);
    //end Daterange
</script>
