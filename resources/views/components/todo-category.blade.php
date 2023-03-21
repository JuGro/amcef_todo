@props(['category', 'with_filter'])

@if ($category)
    @if($with_filter ?? false)
        <a href="{{ url()->current() }}/?category={{ $category->id }}">
            <div {{ $attributes->merge(['class' => 'font-bold mb-4 mt-1']) }} >
                <span class="bg-black text-white rounded-xl px-3 py-1 mr-2"> {{ $category->name }}</span>
            </div>
        </a>
    @else
        <div {{ $attributes->merge(['class' => 'font-bold mb-4 mt-1']) }} >
            <span class="bg-black text-white rounded-xl px-3 py-1 mr-2"> {{ $category->name }}</span>
        </div>    
    @endif    
@endif