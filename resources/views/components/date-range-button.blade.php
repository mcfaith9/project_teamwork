<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
        <x-tabler-calendar-event class="h-4 w-4 text-gray-800 dark:text-black" />
    </button>
    
    <div class="absolute z-10 right-0 mt-2 rounded-md shadow-xl bg-white ring-1 ring-black ring-opacity-5" x-show="open" @click.away="open = false">
        <div class="bg-white rounded-md p-4 text-center" style="width: 15rem;">
            <p class="font-bold text-sm mb-2">Pick Start Date and Due Date</p>
            <input id="datepicker{{ $this->id }}" class="border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md w-full py-2 px-3 mb-4 leading-tight" type="text" placeholder="Select Date Range" wire:onchange="$this->notify('success', 'Start Date and Due Date save successfully');">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
<script>
    const range = new easepick.create({
        element: document.getElementById('datepicker{{ $this->id }}'),
        css: [
            'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
        ],
        plugins: ['RangePlugin'],
        setup(range) {
            range.on('select', (e) => {
                let start = e.detail.start;
                let end = e.detail.end;
                $.ajax({
                    url: "{{ route('task.attribute.store-date-range') }}",
                    method: "POST",
                    data: {   
                        id: {{ $this->data->id }},                     
                        start: start.format('YYYY-MM-DD'),
                        end: end.format('YYYY-MM-DD'),
                        _token: "{{ csrf_token() }}",
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                });
            });
        }
    });

    let start_date = "{{ $data->attribute()->pluck('start_date')->first() }}";
    let due_date = "{{ $data->attribute()->pluck('due_date')->first() }}";
    range.setDateRange(start_date, due_date);
</script>