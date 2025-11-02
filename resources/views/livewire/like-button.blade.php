<div class="mx-3">
    <button wire:click="toggleLike"  style="border: none; background: none;">
        @if ($hasLiked)
            <i class="bi bi-hand-thumbs-up-fill" style="color: #0099ff; font-size: 20px;" ></i>
        @else
            <i class="bi bi-hand-thumbs-up"  style=" font-size: 20px;" ></i>
        @endif
    </button>
    <span>{{ $post->likedBy()->count() }}</span>
</div>