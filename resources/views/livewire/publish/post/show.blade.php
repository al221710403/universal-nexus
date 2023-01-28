@push('scripts')
<link rel="stylesheet" href="{{ asset('vendor/prism/prism.css') }}">
<style>
    :root {
        --ck-image-style-spacing: 1.5em;
        --ck-inline-image-style-spacing: calc(var(--ck-image-style-spacing)/2);
        --ck-color-image-caption-background: #f7f7f7;
        --ck-color-image-caption-text: #333;
        --ck-color-image-caption-highligted-background: #fd0;
    }

    .ck-editor__main {
        word-wrap: break-word;
        background: transparent;
        border: 0;
        margin: 0;
        padding: 0;
        text-decoration: none;
        transition: none;
        vertical-align: middle;
    }

    .ck-content {
        padding: 0 var(--ck-spacing-standard);
    }

    .ck-content .image,
    .ck-conten .image-inline {
        position: relative;
    }

    .ck-content p+.image-style-align-left,
    .ck-content p+.image-style-align-right,
    .ck-content p+.image-style-side {
        margin-top: 0;
    }

    .ck-content p>img {
        clear: both;
        display: table;
        margin: 0.9em auto;
        min-width: 50px;
        text-align: center;
        float: left;
        margin-right: var(--ck-image-style-spacing);
        max-width: 50%;
    }

    .ck-content p+.image-style-align-left,
    .ck-content p+.image-style-align-right,
    .ck-content p+.image-style-side {
        margin-top: 0;
    }

    .ck-content .image-style-side {
        float: right;
        margin-left: var(--ck-image-style-spacing);
        max-width: 50%;
    }

    .ck-content .image {
        clear: both;
        display: table;
        margin: 0.9em auto;
        min-width: 50px;
        text-align: center;
    }

    .ck-content .image>figcaption {
        background-color: var(--ck-color-image-caption-background);
        caption-side: bottom;
        color: var(--ck-color-image-caption-text);
        display: table-caption;
        font-size: .75em;
        outline-offset: -1px;
        padding: 0.6em;
        word-break: break-word;
        border: 1px solid transparent;
    }

    .ck-content p {
        font-size: 1rem
            /* 16px */
        ;
        line-height: 1.5rem
            /* 24px */
        ;

        --tw-text-opacity: 1;
        color: rgb(82 82 82 / var(--tw-text-opacity));
    }

    .ck-content blockquote {
        border-left: 5px solid #ccc;
        font-style: italic;
        margin-left: 0;
        margin-right: 0;
        overflow: hidden;
        padding-left: 1.5em;
        padding-right: 1.5em;
        font-weight: 600;
        --tw-text-opacity: 1;
        color: rgb(115 115 115 / var(--tw-text-opacity));
    }
</style>
@endpush

<div class="container mx-auto py-4 mb-4">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <article class="lg:col-span-2 bg-white rounded-md shadow-lg p-3 relative">
            @if ( Auth::user()->id == $post->author->id )
            <span class="absolute z-20 top-0 right-0  bg-gray-400 text-white px-2 py-1">
                {{$post->public ? 'Público' : 'Privado'}}
            </span>
            @endif
            @if ($post->featured_image != 'noimg.png')
            <div class="mb-4 md:mb-0 w-full mx-auto relative h-80 text-base">
                <div class="absolute left-0 bottom-0 w-full h-full z-10"
                    style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div>
                <img src="{{Storage::url($post->featured_image)}}"
                    class="absolute left-0 top-0 w-full h-full z-0 object-cover" />
                <div class="p-4 absolute bottom-0 left-0 z-20">
                    <h1 class="text-4xl font-semibold text-gray-100 leading-tight">
                        {{$post->title}}
                    </h1>
                    <div class="flex mt-3">
                        <img src="{{$post->author->profile_photo_url}}" class="h-10 w-10 rounded-full mr-2 object-cover"
                            alt="{{$post->author->name}}" />
                        <div>
                            <p class="font-semibold text-gray-200 text-sm"> {{$post->author->name}} </p>
                            <p class="font-semibold text-gray-400 text-xs">
                                <time datetime=" {{$post->publish_date}}">
                                    <i class='bx bxs-calendar'></i>
                                    {{ Carbon\Carbon::parse($post->publish_date)->isoFormat('D MMMM') }}
                                </time>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="mb-2 md:mb-0 w-full mx-auto pb-1">
                <h1 class="text-3xl font-semibold text-gray-500 leading-tight text-left w-full inline-block">
                    {{$post->title}}</h1>
                <ul class="flex justify-between">
                    <li class="flex items-center">
                        <img src="{{$post->author->profile_photo_url}}" class="mr-1 h-6 w-6 rounded-full object-cover"
                            alt="{{$post->author->name}}" />
                        <p class="font-semibold text-gray-400 text-xs"> {{$post->author->name}} </p>
                    </li>
                    <li class="font-semibold text-gray-400 text-xs flex items-center">
                        <time datetime=" {{$post->publish_date}}">
                            <i class='bx bxs-calendar'></i>
                            {{ Carbon\Carbon::parse($post->publish_date)->isoFormat('D MMMM') }}
                        </time>
                    </li>
                </ul>
            </div>
            <hr class="mb-3 md:mb-2" />
            @endif

            <div class="ck-editor__main">
                <div class="ck-content mt-2">
                    {!!$post->body!!}
                </div>
            </div>

            <hr class="mt-4" />
            <footer class="flex flex-wrap mt-2">
                @foreach ($post->tags as $tag)
                <span class="inline-blog px-3 mt-2 mr-2 h-6 bg-gray-400 text-white rounded-full">
                    # {{$tag->name}}
                    {{-- <a href="{{ route('publish.posts.index', $tag->id) }}">
                        # {{$tag->name}}
                    </a> --}}
                </span>
                @endforeach
            </footer>

        </article>

        {{-- Articulos similares --}}
        <aside>
            <h2 class="text-xl font-bold text-gray-600 mb-4">
                Artículos similares
            </h2>

            <ul>
                @forelse ($similares as $item)
                <li class="mb-4 h-32 overflow-hidden bg-white shadow-lg">
                    <a href="{{ route('publish.posts.show', $item->slug) }}" class="flex" title="{{$item->title}}">
                        <img class="w-36 h-32 object-cover object-center" src="{{Storage::url($item->featured_image)}}"
                            alt="portada: {{$item->title}}">
                        <div class="flex-1 ml-2 flex flex-col overflow-hidden py-1">
                            <h3 class="block mb-1 text-gray-700 font-semibold text-base truncate">
                                {{-- {{Str::limit($item->title,
                                30)}} --}}
                                {{$item->title}}
                            </h3>
                            <p class="text-clip max-w-full max-h-32 text-sm flex-1 flex-wrap">
                                {{$item->featured_image_caption}}
                            </p>
                        </div>
                    </a>
                </li>
                @empty
                <li>
                    No ahí artículos similares
                </li>
                @endforelse
            </ul>
        </aside>

    </div>

</div>


@push('scripts')
<script src="{{ asset('vendor/prism/prism.js') }}"></script>
@endpush
