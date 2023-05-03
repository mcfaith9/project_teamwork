<x-filament::page>

    <style type="text/css">
        pre {
          background-color: #f5f5f5;
          color: #333;
          font-size: 14px;
          font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
          padding: 10px;
          border-radius: 4px;
          overflow-x: auto;
          margin-bottom: 15px;
          white-space: pre-wrap;
          word-wrap: break-word;
        }

        blockquote {
          margin: 0;
          padding: 1rem;
          background-color: #f5f5f5;
          border-left: 4px solid #e2e8f0;
          border-radius: 4px;
          font-style: italic;
          color: #718096;
        }
    </style>

    <div class="bg-white shadow-lg rounded-lg px-6 py-4 dark:bg-gray-800">
        <h2 class="text-2xl font-bold mb-2 dark:text-white">{{ $data['title'] }}</h2>
        <p class="text-gray-700 mb-4 dark:text-gray-300">{{ $data['description'] }}</p>

        <div class="border-t border-gray-300 mt-4"></div>
        <div class="flex flex-wrap mt-4">
            <span class="font-bold mr-1">{{ __('Assigned to') }}: </span>
            @foreach($data['users'] as $user)
                <span class="inline-block rounded-full px-3 py-1 text-sm font-semibold text-black-500 mr-2 mb-4 bg-gray-300">
                    <div class="flex items-center">
                        <x-heroicon-s-user class="text-black-500 mr-2 w-4 h-4"/>
                        <span>{{ $user->name }}</span>
                    </div>
                </span>
            @endforeach

            <div class="flex items-center space-x-2 ml-auto">
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-tabler-calendar-event class="h-4 w-4 text-gray-800 dark:text-black" />
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-css-sand-clock class="h-4 w-4 text-gray-800 dark:text-black" />    
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-tabler-bell class="h-4 w-4 text-gray-800 dark:text-black" />     
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-tabler-tag class="h-4 w-4 text-gray-800 dark:text-black" />     
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <x-tabler-flag-3 class="h-4 w-4 text-gray-800 dark:text-black" />     
                </button>
                <button class="flex items-center text-gray-500 hover:text-gray-900 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-800">1%</span>      
                </button>
            </div>
        </div>
    </div>      

    <div class="px-4">        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion ({{ count($comments) }})</h2>
        </div>

        <button wire:click="$toggle('showComments')" class="flex items-center space-x-1 text-sm font-medium text-blue-500 hover:text-blue-700">
            <x-tabler-arrow-down class="w-4 h-4"/>
            <span>{{ $showComments ? 'Hide' : 'Show' }} Comments</span>
        </button>

        <div x-data="{ showComments: @entangle('showComments').defer }" x-show="showComments" class="mt-4" wire:poll.2000s="refreshComments">
            @foreach($comments as $comment)
                <article class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-800">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                <x-heroicon-s-user class="mr-2 w-6 h-6 rounded-full bg-gray-200"/>
                                {{ $comment->user->name }}
                            </p>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <time>{{ $comment->created_at->format('F d, Y') }}</time>
                            </p>
                        </div>
                        <button class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <x-tabler-dots class="w-4 h-4" />
                            <span class="sr-only">Comment settings</span>
                        </button>
                    </footer>     

                    <div class="ml-4">
                        {!! $comment->body !!}
                        
                        @if(!empty($comment->attachments))
                            <div class="text-center">
                                @foreach(json_decode($comment->attachments) as $attachment)
                                    <img src="{{ asset($comment->image_url[$loop->index]) }}" alt="Attachment" class="object-cover object-center mx-2 my-4 rounded-md inline-flex dark:filter dark:grayscale dark:opacity-75" style="max-width: 650px;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center mt-4 space-x-4">
                        <a href="#comment-form" class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 ml-auto">
                            <x-heroicon-s-chat class="w-4 h-4 mr-2" /> Reply
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>


    <div id="comment-form" class="bg-white shadow-lg rounded-lg px-4 py-4 dark:bg-gray-800">       

        <form class="mb-4" wire:submit.prevent="submit">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-4">Submit</x-filament::button>
        </form>
    </div>

</x-filament::page>
