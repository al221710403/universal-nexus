@if ($readyToLoad)
@if ($action == "show")
@include('livewire.toDo.parts.view-task-show');
@else
@include('livewire.toDo.parts.view-task-edit');
@endif
@else
<section wire:init="loadPosts" class="bg-white z-20 py-2 px-3">

    <header class="mb-1.5 flex items-center animate-pulse">
        <div class="h-2.5 my-auto bg-gray-400 rounded-full w-48"></div>
    </header>
    <hr />
    <div class="mt-2 animate-pulse flex items-center space-x-3">
        <svg class="text-gray-400 w-14 h-14" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                clip-rule="evenodd"></path>
        </svg>
        <div>
            <div class="h-2.5 bg-gray-400 rounded-full w-32 mb-2"></div>
            <div class="w-48 h-2 bg-gray-400 rounded-full"></div>
        </div>
    </div>

    <div role="status" class="mt-4 space-y-2.5 animate-pulse max-w-lg">
        <div class="flex items-center w-full space-x-2">
            <div class="h-2.5 bg-gray-300 rounded-full w-32"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-24"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
        </div>
        <div class="flex items-center w-full space-x-2 max-w-[480px]">
            <div class="h-2.5 bg-gray-300 rounded-full w-full"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-24"></div>
        </div>
        <div class="flex items-center w-full space-x-2 max-w-[400px]">
            <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
            <div class="h-2.5 bg-gray-300 rounded-full w-80"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
        </div>
        <div class="flex items-center w-full space-x-2 max-w-[480px]">
            <div class="h-2.5 bg-gray-300 rounded-full w-full"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-24"></div>
        </div>
        <div class="flex items-center w-full space-x-2 max-w-[440px]">
            <div class="h-2.5 bg-gray-400 rounded-full w-32"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-24"></div>
            <div class="h-2.5 bg-gray-300 rounded-full w-full"></div>
        </div>
        <div class="flex items-center w-full space-x-2 max-w-[360px]">
            <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
            <div class="h-2.5 bg-gray-300 rounded-full w-80"></div>
            <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
        </div>
        <span class="sr-only">Loading...</span>
    </div>

    <div class="mt-3 space-y-8 animate-pulse md:space-y-0 md:space-x-8 md:flex md:items-center">
        <div role="status" class="w-full">
            <div class="h-2.5 bg-gray-400 rounded-full w-48 mb-4"></div>
            <div class="h-2 bg-gray-400 rounded-full max-w-[480px] mb-2.5"></div>
            <div class="h-2 bg-gray-400 rounded-full mb-2.5"></div>
            <div class="h-2 bg-gray-400 rounded-full max-w-[440px] mb-2.5"></div>
            <div class="h-2 bg-gray-400 rounded-full max-w-[460px] mb-2.5"></div>
            <div class="h-2 bg-gray-400 rounded-full max-w-[360px]"></div>
        </div>
    </div>
</section>
@endif
