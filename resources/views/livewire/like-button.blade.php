<div class="inline-flex items-center gap-2">
    <button wire:click="toggleLike" class="focus:outline-none" aria-label="Toggle like">
        @if ($hasLiked)
            <!-- solid (filled) thumbs-up -->
            <i class="fas fa-thumbs-up text-blue-600 transition-transform hover:scale-105"></i>
        @else
            <!-- regular (outline) thumbs-up -->
            <i class="far fa-thumbs-up text-slate-400 transition-colors hover:text-slate-200"></i>
        @endif
    </button>

    <span class="ml-1 text-sm text-slate-300">{{ $post->likedBy()->count() }}</span>
</div>
