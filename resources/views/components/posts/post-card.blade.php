@props(['post'])

<div class="main-card my-6 relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100 rounded-xl shadow-lg border border-slate-700 p-5 transition">

    {{-- Skeleton Loader --}}
    <div class="skeleton-card animate-pulse" id="skeleton-loader-{{ $post->id }}">
        <div class="flex items-center space-x-3 mb-4">
            <div class="rounded-full bg-slate-700 h-10 w-10"></div>
            <div class="flex-1 space-y-2 py-1">
                <div class="h-3 bg-slate-700 rounded w-3/4"></div>
                <div class="h-3 bg-slate-700 rounded w-1/2"></div>
            </div>
        </div>
        <div class="space-y-2">
            <div class="h-3 bg-slate-700 rounded w-full"></div>
            <div class="h-3 bg-slate-700 rounded w-5/6"></div>
            <div class="h-3 bg-slate-700 rounded w-3/4"></div>
        </div>
        <div class="mt-4 h-48 bg-slate-700 rounded-lg"></div>
    </div>

    {{-- Actual Post Card --}}
    <div class="post-card-content hidden" id="real-card-{{ $post->id }}">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ $post->user->profile_photo_path ? asset('storage/' . $post->user->profile_photo_path) : asset('assets/img/profile-photo.jpg') }}" 
                     alt="Profile Photo" class="h-11 w-11 rounded-full border border-slate-700">
                <div>
                    <h5 class="text-base font-semibold hover:text-blue-400 transition">
                        <a href="{{ route('users.posts', $post->user->id) }}">{{ $post->user->name }}</a>
                    </h5>
                    <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="relative">
                <button onclick="toggleDropdown({{ $post->id }})" class="text-gray-400 hover:text-gray-200 focus:outline-none">
                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                </button>
                <ul id="dropdown-{{ $post->id }}" class="hidden absolute right-0 mt-2 w-40 bg-slate-800 border border-slate-700 rounded-lg shadow-lg z-50">
                    <li>
                        <x-share-button :url="route('posts.show', $post->slug)" />

                    </li>
                    @auth
                        @if(auth()->id() === $post->user->id)
                            <li>
                                <a href="{{ route('posts.edit', $post->slug) }}" 
                                   class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700">
                                   <i class="fa-solid fa-pen mr-2"></i> Edit
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('posts.destroy', $post->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-slate-700"
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                        <i class="fa-solid fa-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>

        <!-- Post Body -->
        <div class="mt-4 text-[15px] leading-relaxed">
            <p id="short-text-{{ $post->id }}" class="text-gray-100">
                {{ Str::limit($post->body, 200) }}
                @if(strlen($post->body) > 200)
                    <span class="text-blue-400 cursor-pointer font-medium ml-1" onclick="toggleReadMore({{ $post->id }})">
                        Continue reading
                    </span>
                @endif
            </p>
            <p id="full-text-{{ $post->id }}" class="hidden text-gray-100">
                {{ $post->body }}
                <span class="text-blue-400 cursor-pointer font-medium ml-1" onclick="toggleReadMore({{ $post->id }})">
                    Show less
                </span>
            </p>
        </div>

        <!-- Post Image -->
        @if($post->image)
        <div class="mt-4">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="rounded-lg w-full max-h-96 object-cover shadow-md">
        </div>
        @endif

        <!-- Actions -->
        <div class="flex items-center justify-between mt-4 border-t border-slate-700 pt-3 text-gray-400 text-sm">
            <div class="flex items-center gap-2 ">
                <livewire:like-button :post="$post" />
            </div>
            <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center gap-2 hover:text-blue-400 transition">
                <i class="fa-regular fa-comment"></i> 
                <span>{{ $post->comments->count() }}</span>
            </a>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.getElementById('skeleton-loader-{{ $post->id }}').style.display = 'none';
            document.getElementById('real-card-{{ $post->id }}').classList.remove('hidden');
        }, 200);
    });

    function toggleReadMore(postId) {
        const shortText = document.getElementById(`short-text-${postId}`);
        const fullText = document.getElementById(`full-text-${postId}`);

        shortText.classList.toggle('hidden');
        fullText.classList.toggle('hidden');
    }

    function toggleDropdown(postId) {
        const dropdown = document.getElementById(`dropdown-${postId}`);
        dropdown.classList.toggle('hidden');

        // Close dropdown when clicking outside
        document.addEventListener('click', function handler(e) {
            if (!dropdown.contains(e.target) && !e.target.closest(`[onclick="toggleDropdown(${postId})"]`)) {
                dropdown.classList.add('hidden');
                document.removeEventListener('click', handler);
            }
        });
    }
</script>
