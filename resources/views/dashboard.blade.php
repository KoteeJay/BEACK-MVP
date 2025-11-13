@extends('layouts.app')
@section('content')
@livewire('search-box')

<div class="flex min-h-screen space-y-10">

   <!-- Sidebar -->
        <aside id="sidebar"class="sidebar lg:w-1/4 border-r border-blue-300 bg-slate-900 text-gray-100 space-y-6">
            <h1> <br> <br> <br></h1>
            <ul class="space-y-10 pl-5 fixed">
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('dashboard') }}">
                        <i class="fa fa-table-cells-large"></i>
                        <span>Overview</span>
                    </a>
                </li>
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('dashboard.create') }}">
                        <i class="fa fa-pen-to-square"></i>
                        <span>Create new post</span>
                    </a>
                </li>
                <li class="nav-item hidden md:block">
                    <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('dashboard.profile') }}">
                        <i class="fa fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>

                @auth
                    @if (auth()->user()->user_type === 'super_admin')
                        <li class="nav-item">
                            <a class="flex items-center gap-2 px-4 py-2 hover:bg-blue-700 rounded" href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-users"></i>
                                <span>User Management</span>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
</aside>
        <!-- End Sidebar -->

    <!-- Main Content -->
    <main class="w-full sm:w-11/12 md:w-4/5 lg:w-2/3 xl:w-1/2 bg-slate-900 p-4 sm:p-6 mx-auto rounded-lg">
      <div id="posts-container" class="space-y-9">
         @if($posts->isEmpty())
            <div class="flex flex-col items-center justify-center text-center py-20">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" class="w-24 mb-4 opacity-80" alt="">
                <h3 class="text-xl font-semibold mb-2">No Posts Yet</h3>
                <p class="text-slate-400 mb-4">Start sharing your thoughts with the world!</p>
                <a href="{{ route('dashboard.create') }}" 
                   class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg">
                   Create Your First Post
                </a>
            </div>
        @else
            @foreach ($posts as $post)
                <div id="real-card-{{ $post->id }}" class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg p-5 transition hover:border-blue-500 relative group">
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $post->user->profile_photo_path ? asset('storage/' . $post->user->profile_photo_path) : asset('assets/img/profile-photo.jpg') }}" 
                                 alt="Profile Photo" class="h-11 w-11 rounded-full border border-slate-700">
                            <div>
                                <h5 class="text-base font-semibold text-gray-200 transition">
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
                            <ul id="dropdown-{{ $post->id }}" 
                                class="hidden absolute right-0 mt-2 w-40 bg-slate-800 border border-slate-700 rounded-lg shadow-lg z-50">
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

                    <!-- Body -->
                    <div class="text-[15px] text-slate-100 leading-relaxed mb-3">
                        @if(Str::length($post->body) > 250)
                            {{ Str::limit($post->body, 250) }}
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-400 hover:underline ml-1">Continue Reading</a>
                        @else
                            {{ $post->body }}
                        @endif
                    </div>

                    <!-- Image -->
                    @if($post->image)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $post->image) }}" 
                                 alt="Post Image" 
                                 class="rounded-lg w-full max-h-96 object-cover border border-slate-700">
                        </div>
                    @endif

                    <!-- Footer -->
                    <div class="flex justify-between items-center mt-4 text-slate-400 text-sm border-t border-slate-700 pt-3">
                        <livewire:like-button :post="$post" />
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="flex items-center gap-1 hover:text-blue-400">
                            <i class="fa-regular fa-comment"></i> {{ $post->comments->count() }}
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
        <!-- Floating Action Button (Mobile Only) -->
        <div class="fixed bottom-6 right-6 z-50 md:hidden">
            <!-- Main FAB -->
            <button id="fab-btn" 
                class="bg-blue-600 hover:bg-blue-500 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center text-2xl transition transform hover:scale-105">
                <i class="fa fa-plus"></i>
            </button>

            <!-- Hidden Action Buttons -->
            <div id="fab-actions" class="flex flex-col items-end space-y-3 mt-3 hidden">
                <!-- Create Post -->
                <a href="{{ route('dashboard.create') }}" 
                class="bg-blue-600 hover:bg-blue-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-md transition transform hover:scale-110">
                    <i class="fa fa-pen-to-square text-lg"></i>
                </a>

                <!-- Profile -->
                <a href="{{ route('dashboard.profile') }}" 
                class="bg-blue-700 hover:bg-blue-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-md transition transform hover:scale-110">
                    <i class="fa fa-user text-lg"></i>
                </a>
            </div>
        </div>

      </div>
    </main>

    <div class="flex-1"></div>
</div>


@push('scripts')
<script>
// ✅ Dropdown toggle logic
function toggleDropdown(postId) {
    const dropdown = document.getElementById(`dropdown-${postId}`);
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

    allDropdowns.forEach(el => {
        if (el !== dropdown) el.classList.add('hidden');
    });

    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function (event) {
    if (!event.target.closest('.relative')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

    // Floating Action Button Toggle
    document.getElementById('fab-btn').addEventListener('click', () => {
        const actions = document.getElementById('fab-actions');
        actions.classList.toggle('hidden');
        actions.classList.toggle('animate-fadeIn');
    });
    </script>

    <style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.2s ease-out;
    }
    </style>
</script>
@endpush

@endsection
