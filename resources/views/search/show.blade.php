@extends('layouts.app')
@section('content')

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <x-sidebar class="hidden md:block" />
   

    <!-- Main Content -->
    <main class="w-full sm:w-11/12 md:w-4/5 lg:w-2/3 xl:w-1/2 bg-slate-900 p-4 sm:p-6 mx-auto rounded-lg">
        <!-- Page content goes here -->
        <div id="posts-container" class="space-y-6">
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
                    {{ $post->body }}
                    
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
                <a href="#" class="flex items-center gap-2 hover:text-blue-400 transition">
                    <i class="fa-regular fa-comment"></i> 
                    <span>{{ $post->comments->count() }}</span>
                </a>
            </div>
        </div>
            <!-- Post comment -->
<div class="comments my-5 p-4 bg-slate-800 rounded-lg shadow-md">
    <h5 class="text-white text-lg font-semibold mb-4">Comments</h5>

    <!-- Existing comments -->
    <div class="space-y-4">
        @foreach ($post->comments as $comment)
            <div class="comment bg-slate-700 p-3 rounded-lg">
                <p class="text-slate-100 text-sm">
                    {{ $comment->body }}
                </p>
                <span class="text-slate-400 text-xs italic mt-1 block">
                    By {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>
        @endforeach
    </div>

    <!-- Add new comment -->
    @auth
        <form action="{{ route('comments.store') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            
            <textarea 
                name="body" 
                rows="3" 
                placeholder="Leave a comment..." 
                required
                class="w-full px-4 py-2 rounded-lg border border-slate-600 bg-slate-900 text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
            
            <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg transition">
                Add Comment
            </button>
        </form>
    @endauth
</div>

    </main>

    <!-- Optional empty space to balance layout -->
    <div class="flex-1"></div>

</div>


@endsection

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel" style="color:rgb(20, 20, 20);">Share This Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Share Options -->
                <div class="share-options">
                    <!-- Copy Link -->
                    <div class="mb-3">
                        
                        <div class="input-group">
                            <input type="text" class="form-control" id="shareUrl" 
                                   value="{{ url()->current() }}" readonly>
                            <button class="btn btn-outline-primary" onclick="copyToClipboard(this)">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copy toast -->
<div id="copy-toast" aria-live="polite" aria-atomic="true" style="position:fixed; right:20px; bottom:20px; padding:10px 14px; background:rgba(0,0,0,0.85); color:#fff; border-radius:8px; display:none; z-index:2000; opacity:0; transition:opacity .2s ease-in-out; box-shadow:0 6px 18px rgba(0,0,0,0.2);">
    <span id="copy-toast-message"></span>
</div>
  

<script>
    
    document.addEventListener('DOMContentLoaded', () => {
        // Get all post IDs from the data attributes
        const skeletonLoaders = document.querySelectorAll('[id^="skeleton-loader-"]');
        
        setTimeout(() => {
            skeletonLoaders.forEach(loader => {
                const postId = loader.id.replace('skeleton-loader-', '');
                loader.style.display = 'none';
                document.getElementById(`real-card-${postId}`).style.display = 'block';
            });
        }, 200);
    });
    document.addEventListener('click', function (e) {
    if (e.target.matches('.like-btn') || e.target.matches('.unlike-btn')) {
        e.preventDefault();

        const form = e.target.closest('form');
        const url = form.action;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.text())
        .then(() => {
            location.reload(); // Reload the page to update the like count
        })
        .catch(error => console.error('Error:', error));
    }
    });
    function showLoginPrompt() {
        if (confirm('You need to log in to like this post. Do you want to log in now?')) {
            window.location.href = '{{ route('login') }}?redirect_to=' + encodeURIComponent(window.location.href);
        }
    }

    function toggleDropdown(id) {
        const dropdown = document.getElementById(`dropdown-${id}`);
        if (!dropdown) return;

        // Close any other open dropdowns
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
            if (el.id !== `dropdown-${id}`) el.classList.add('hidden');
        });

        // Toggle the clicked one
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown if user clicks outside
    document.addEventListener('click', function (e) {
        const isDropdown = e.target.closest('[id^="dropdown-"]');
        const isButton = e.target.closest('button[onclick^="toggleDropdown"]');
        if (!isDropdown && !isButton) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
        }
    });
 
    
</script>
