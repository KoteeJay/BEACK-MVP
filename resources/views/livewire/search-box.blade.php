<div class="search-bar m-auto">
    <form class="search-form d-flex align-items-center" wire:submit.prevent="search">
        @csrf
        <input wire:model.live.debounce.300ms="query" 
        type="text" name="query" 
        placeholder="Search" 
        title="Enter search keyword">
        <button   wire:model="query"  type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>

    <ul class="list-group mt-3">
        @forelse ($posts as $post)
            <li class="list-group-item py-3">
                <a href="{{ route('search.show', $post->id) }}">{{ Str::limit($post->body, 50) }}</a>
            </li>
        @empty
            {{-- <li class="list-group-item">No posts found.</li> --}}
        @endforelse
    </ul>
</div>