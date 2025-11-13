<div class="relative hidden md:flex w-full max-w-md mx-auto">
    <form wire:submit.prevent="search" class="relative flex justify-between">
        @csrf
        <!-- Search Input -->
        <input 
            wire:model.live.debounce.300ms="query" 
            type="text" 
            name="query" 
            placeholder="Search..." 
            class="w-full px-20 rounded-full border border-slate-600 bg-slate-800 text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        >

        <!-- Search Icon -->
        {{-- <button type="submit" title="Search" class="absolute left-3 inset-y-0 flex items-center text-slate-400 hover:text-slate-200">
            <i class="bi bi-search text-lg"></i>
        </button> --}}
    </form>

    <!-- Search Results Dropdown -->
    @if (!empty($posts))
    <ul class="absolute w-full mt-20 bg-slate-800 border border-slate-700 rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
        @forelse ($posts as $post)
            <li class="px-4 py-2 hover:bg-slate-700 transition">
                <a href="{{ route('search.show', $post->id) }}" class="text-slate-100 text-sm block">
                    {{ Str::limit($post->body, 60) }}
                </a>
            </li>
        @empty
            <li class="px-4 py-2 text-slate-400 text-sm">No posts found.</li>
        @endforelse
    </ul>
    @endif
</div>
