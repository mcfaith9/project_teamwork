<x-filament::page>
    
    <style type="text/css">
        pre {
            /*background-color: #f5f5f5;
            color: #333;*/
            background-color: #1f2937;
            border-radius: 0.375rem;
            color: #e5e7eb;
            font-size: .875em;
            font-weight: 400;
            line-height: 1.7142857;
            margin-bottom: 1.7142857em;
            overflow-x: auto;
            padding: 0.8571429em 1.1428571em;
            font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
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
        <h2 class="text-2xl font-bold mb-2 dark:text-white">{{ $task['title'] }}</h2>
        <p class="text-gray-700 mb-4 dark:text-gray-300">{{ $task['description'] }}</p>

        <div class="border-t border-gray-300 mt-4"></div>
        <div class="flex flex-wrap mt-4">
            <span class="font-semibold mr-3 italic text-sm">{{ __('Assigned to') }}: </span>
            @foreach($task['users'] as $user)
                <span class="inline-block rounded-full p-2 text-sm font-semibold text-black-500 mr-2 mb-4 bg-gray-200 dark:bg-gray-700">
                    <div class="flex items-center">
                        <x-filament::user-avatar :user="$user" class="text-black-500 mr-1 w-5 h-5"/>
                        <span>{{ __($user->name) }}</span>
                    </div>
                </span>
            @endforeach

            <div class="flex items-center space-x-2 ml-auto">    
                @include('components.task-attribute-buttons')                
            </div>
        </div>  

        @include('components.subtask')
    </div>      

    <section x-data="{ open: true }">

        <button @click="open = !open" wire:click="$toggle('showComments')" class="flex items-center space-x-1 text-sm font-medium text-blue-500 hover:text-blue-700">            
            <span class="font-semibold mr-1">Discussion ({{ count($comments) }})</span>
            <span class="italic text-sm">{{ $showComments ? 'Hide' : 'Show' }} Comments</span>
            <x-tabler-arrow-up class="w-4 h-4" x-show="!open"/>
            <x-tabler-arrow-down class="w-4 h-4" x-show="open"/>
        </button>

        <div x-data="{ showComments: @entangle('showComments').defer }" x-show="showComments" class="mt-4" wire:poll.2000s="refreshComments">
            @foreach($comments as $comment)
                <article class="p-6 mb-6 text-base rounded-lg dark:bg-gray-800">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center text-md text-gray-900 dark:text-white">
                                <x-filament::user-avatar :user="$comment->user" class="mr-2 w-10 h-10" />
                                <b>{{ $comment->user->name }}</b>
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <time class="ml-2 italic text-sm"> commented on {{ $comment->created_at->diffForHumans() }}</time>
                            </p>
                        </div>

                        <div class="flex">
                            <a href="#comment-form" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-gray-100 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                                <x-css-mail-reply class="w-6 h-6 text-gray-500 " />
                                <span class="sr-only">Comment settings</span>
                            </a>
                            <button class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-gray-100 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                                <x-tabler-dots class="w-6 h-6 text-gray-500 " />
                                <span class="sr-only">Comment settings</span>
                            </button>
                        </div>
                    </footer>     

                    <div class="ml-4" style="border-left: 4px solid #e2e8f0; padding: 1rem;">
                        {!! $comment->body !!}
                        
                        @if(!empty($comment->attachments))
                            <div class="text-center mt-4">
                                @foreach(json_decode($comment->attachments) as $attachment)
                                    <img src="{{ asset($comment->image_url[$loop->index]) }}" alt="Attachment" class="object-cover object-center mx-2 my-4 rounded-md inline-flex dark:filter dark:grayscale dark:opacity-75" style="max-width: 650px;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <div id="comment-form" class="bg-white shadow-lg rounded-lg px-4 py-4 dark:bg-gray-800">       

        <form class="mb-4" wire:submit.prevent="submit">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-4">Comment</x-filament::button>
        </form>
    </div>

</x-filament::page>
